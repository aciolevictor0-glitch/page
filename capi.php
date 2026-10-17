<?php
/**
 * API de Conversões da Meta (servidor) para a LP Radar do Estoque.
 *
 * A página envia aqui os mesmos eventos do Pixel (PageView e Lead), com o
 * mesmo event_id, e este arquivo repassa para a Meta pelo servidor. A Meta
 * junta os dois (deduplicação) e recupera eventos que o navegador perdeu.
 *
 * O token NUNCA fica no GitHub. Crie o arquivo capi-config.php na pasta
 * ACIMA da public_html (veja capi-config.example.php e o README).
 *
 * GET  capi.php  -> diagnóstico {"ok":true,"configurado":true|false}
 * POST capi.php  -> recebe o evento da página (JSON)
 */

header('Content-Type: application/json; charset=utf-8');
header('X-Robots-Tag: noindex');
header('Cache-Control: no-store');

// Domínios autorizados a enviar eventos
$DOMINIOS = ['marianaveiculos.com.br', 'www.marianaveiculos.com.br'];
$EVENTOS = ['PageView', 'Lead'];

function carregar_config()
{
    $locais = [dirname(__DIR__) . '/capi-config.php', __DIR__ . '/capi-config.php'];
    foreach ($locais as $arquivo) {
        if (is_file($arquivo)) {
            $c = include $arquivo;
            if (is_array($c) && !empty($c['pixel_id']) && !empty($c['token'])) return $c;
        }
    }
    return null;
}

function sair($status, $dados = null)
{
    http_response_code($status);
    if ($dados !== null) echo json_encode($dados);
    exit;
}

$config = carregar_config();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    sair(200, ['ok' => true, 'configurado' => $config !== null]);
}
if ($_SERVER['REQUEST_METHOD'] !== 'POST') sair(405);
if ($config === null) sair(503, ['erro' => 'capi-config.php ausente']);

// Só aceita eventos vindos do próprio site
$origem = $_SERVER['HTTP_ORIGIN'] ?? ($_SERVER['HTTP_REFERER'] ?? '');
$host = parse_url($origem, PHP_URL_HOST);
if (!$host || !in_array(strtolower($host), $DOMINIOS, true)) sair(403);

$bruto = file_get_contents('php://input', false, null, 0, 8192);
$e = json_decode($bruto, true);
if (!is_array($e)) sair(400);

$nome = $e['event_name'] ?? '';
$id = $e['event_id'] ?? '';
$url = $e['event_source_url'] ?? '';
if (!in_array($nome, $EVENTOS, true)) sair(400);
if (!is_string($id) || !preg_match('/^[A-Za-z0-9._-]{8,64}$/', $id)) sair(400);
$urlHost = parse_url($url, PHP_URL_HOST);
if (!$urlHost || !in_array(strtolower($urlHost), $DOMINIOS, true)) sair(400);

// IP real do visitante (a CDN da Hostinger repassa no X-Forwarded-For)
$ip = $_SERVER['REMOTE_ADDR'] ?? '';
if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $ip = trim(explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0]);
}

$user = [
    'client_ip_address' => $ip,
    'client_user_agent' => substr($_SERVER['HTTP_USER_AGENT'] ?? '', 0, 512),
];
foreach (['fbp', 'fbc'] as $k) {
    if (!empty($e[$k]) && is_string($e[$k]) && preg_match('/^fb\.\d\.\d+\.[A-Za-z0-9_.-]+$/', $e[$k])) $user[$k] = $e[$k];
}

$custom = [];
if (!empty($e['custom_data']) && is_array($e['custom_data'])) {
    foreach (['cta_position', 'headline', 'cta_variant'] as $k) {
        if (isset($e['custom_data'][$k]) && is_scalar($e['custom_data'][$k])) $custom[$k] = substr((string) $e['custom_data'][$k], 0, 40);
    }
}

$evento = [
    'event_name' => $nome,
    'event_time' => time(),
    'event_id' => $id,
    'event_source_url' => substr($url, 0, 1000),
    'action_source' => 'website',
    'user_data' => $user,
];
if ($custom) $evento['custom_data'] = $custom;

$corpo = ['data' => [$evento]];
if (!empty($config['test_event_code'])) $corpo['test_event_code'] = $config['test_event_code'];

$versao = $config['api_version'] ?? 'v25.0';
$ch = curl_init('https://graph.facebook.com/' . $versao . '/' . rawurlencode($config['pixel_id']) . '/events?access_token=' . rawurlencode($config['token']));
curl_setopt_array($ch, [
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => json_encode($corpo),
    CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT => 5,
]);
$resposta = curl_exec($ch);
$codigo = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($codigo >= 200 && $codigo < 300) sair(204);
error_log('CAPI Meta erro ' . $codigo . ': ' . substr((string) $resposta, 0, 500));
sair(502, ['erro' => 'Meta respondeu ' . $codigo]);
