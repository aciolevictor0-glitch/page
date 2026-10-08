# LP Radar do Estoque | Mariana Amorim • Seminovos Importadora

Página única (`index.html`), sem build. Basta subir a pasta em qualquer hospedagem estática (Netlify, Vercel, GitHub Pages, Hostinger).

## Antes de publicar

1. **Link do grupo**: já configurado em `WHATSAPP_GROUP_URL`, no final do `index.html`. Todos os botões usam esse link; se o convite for redefinido no WhatsApp, troque ali.
2. **Foto da Mariana**: salve como `assets/mariana.jpg` (vertical, ~900x1000). Sem ela, aparece um placeholder.
3. **Fotos de carro**: `assets/hero.jpg` (VW Virtus), `assets/estoque.jpg` (VW Taos) e `assets/oferta.jpg` (VW Nivus) são fotos ilustrativas do Wikimedia Commons (licença CC BY, placas borradas). Enquanto forem usadas, mantenha o crédito no rodapé. Ao trocar por fotos reais do estoque, mantenha os nomes dos arquivos e remova a linha `footer__credits`.
4. **Pixel / GA4**: cole os scripts no `<head>` (há um comentário marcando o lugar). Todo clique em CTA dispara `fbq('track','Lead')`, `gtag('event','generate_lead')` e um push `cta_whatsapp_click` no `dataLayer`, com a posição do botão.

## Testes A/B pela URL do anúncio

| Parâmetro | Efeito |
|---|---|
| `?h=a` | Os melhores carros saem antes da divulgação (padrão) |
| `?h=b` | Seminovos em Maceió, antes de todo mundo |
| `?h=c` | Cansou de chegar e o carro já ter sido vendido? |
| `?cta=2` | Botões principais viram "Ver os carros primeiro" |

Exemplo: `https://seudominio.com/?h=c&cta=2`
