# LP Radar do Estoque | Mariana Amorim • Seminovos Importadora

Página única (`index.html`), sem build. Basta subir a pasta em qualquer hospedagem estática (Netlify, Vercel, GitHub Pages, Hostinger).

## Antes de publicar

1. **Link do grupo**: configurado em `config.whatsapp_grupo` no `content.json` (e, como reserva, em `WHATSAPP_GROUP_URL` no final do `index.html`). Todos os botões usam esse link; se o convite for redefinido no WhatsApp, troque ali.
2. **Foto da Mariana**: `assets/mariana.jpg` (bloco de abertura) e `assets/mariana-avatar.jpg` (recorte do rosto usado nos avatares do hero, da autoridade e do celular). Para trocar, mantenha os nomes dos arquivos.
   - **Entregas (prova social)**: `assets/entrega-1.jpg` a `entrega-5.jpg`, com as placas dos clientes borradas. Para adicionar ou trocar, edite a seção `#clientes` do `index.html`.
3. **Fotos de carro**: `assets/hero.jpg` (VW Nivus, com céu e laterais ampliados), `assets/estoque.jpg` (VW Polo), `assets/oferta.jpg` (Fiat Cronos, no celular), `assets/destaque.jpg` (Fiat Argo, card do hero) e `assets/cta-final.jpg` (VW Nivus, fundo do CTA final). Para trocar, mantenha os nomes dos arquivos. O hero tem também `assets/hero-mobile.jpg` (900 px), usado no celular: ao trocar a foto do hero, gere as duas versões.
4. **Meta Pixel**: instalado no `<head>` (ID `1854482842391080`), com PageView no carregamento e `Lead` no clique de qualquer botão do WhatsApp (com a posição do botão em `cta_position`). Também vai um push `cta_whatsapp_click` no `dataLayer`. **GA4**: cole o código no `<head>`, no comentário marcado; o clique já dispara `generate_lead` quando o `gtag` existe.

## Editar textos, link e imagens: `content.json`

Todos os textos da página (142 campos), o link do grupo, as headlines do teste A/B, o título/descrição e as imagens ficam no `content.json`, organizados por seção (`hero`, `abertura`, `dor`, `solucao`, `autoridade`, `clientes`, `oferta`, `celular`, `objecoes`, `garantia`, `urgencia`, `faq`, `cta_final`, `ps`, `rodape`, `barra_fixa`).

- Com a página publicada, o que está no JSON substitui o que está no `index.html`. Edite só o JSON.
- Textos aceitam `<strong>`, `<em>`, `<b>` e `<br>`. Nos títulos, o trecho em `<em>` recebe o destaque âmbar.
- Listas mantêm a quantidade de itens do HTML; para adicionar ou remover um item, edite também o `index.html`.
- Cada elemento editável tem um atributo `data-c="secao.campo"` (texto) ou `data-img="chave"` (imagem) no `index.html`, que aponta para a chave do JSON.
- Aberta direto do computador (`file://`), a página ignora o JSON e usa os textos do HTML. Mantenha os dois iguais ao publicar uma versão nova do HTML.

## Testes A/B pela URL do anúncio

| Parâmetro | Efeito |
|---|---|
| `?h=a` | Os melhores carros saem antes da divulgação (padrão) |
| `?h=b` | Seminovos em Maceió, antes de todo mundo |
| `?h=c` | Cansou de chegar e o carro já ter sido vendido? |
| `?cta=2` | Botões principais viram "Ver os carros primeiro" |

Exemplo: `https://seudominio.com/?h=c&cta=2`

## Publicação na Hostinger (GitHub)

A Hostinger publica o conteúdo da raiz do repositório. Depois de mesclar o PR na `main`, aponte o deploy Git da Hostinger para a branch `main`. O `index.html`, o `content.json` e a pasta `assets/` precisam ficar juntos na pasta pública do site.

## API de Conversões da Meta (`capi.php`)

Cada evento (PageView ao abrir e Lead no clique dos botões do WhatsApp) vai pelo Pixel **e** pelo servidor, com o mesmo `event_id`, e a Meta deduplica. O `capi.php` repassa para a Meta com o IP, o navegador e os cookies `_fbp`/`_fbc` do visitante.

**Ativar (uma vez, na Hostinger):**

1. No Gerenciador de Eventos da Meta, abra o pixel `1854482842391080` > Configurações > API de Conversões > **Gerar token de acesso**.
2. No Gerenciador de Arquivos da Hostinger, crie o arquivo `capi-config.php` na pasta **acima** da `public_html` (a pasta do domínio), com o conteúdo de `capi-config.example.php` e o token colado.
3. Abra `https://marianaveiculos.com.br/capi.php`: deve mostrar `{"ok":true,"configurado":true}`.

- O token nunca vai para o GitHub (`capi-config.php` está no `.gitignore`).
- Para validar no "Testar eventos", preencha `test_event_code` no `capi-config.php` com o código de teste e esvazie depois.
- Só aceita PageView e Lead vindos de `marianaveiculos.com.br`.
