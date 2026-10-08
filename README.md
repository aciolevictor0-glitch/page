# LP Grupo VIP Mariana Amorim | Seminovos Importadora

Página única (`index.html`), sem build. Basta subir a pasta em qualquer hospedagem estática (Netlify, Vercel, GitHub Pages, Hostinger).

## Antes de publicar

1. **Link do grupo**: no final do `index.html`, troque `WHATSAPP_GROUP_URL` pelo convite do grupo. Todos os botões usam esse link.
2. **Foto da Mariana**: salve como `assets/mariana.jpg` (vertical, ~900x1000). Sem ela, aparece um placeholder.
3. **Fotos de carro**: `assets/hero.jpg`, `assets/estoque.jpg` e `assets/oferta.jpg` são fotos temporárias (Unsplash). Troque por carros reais do estoque, mantendo os nomes.
4. **Pixel / GA4**: cole os scripts no `<head>` (há um comentário marcando o lugar). Todo clique em CTA dispara `fbq('track','Lead')`, `gtag('event','generate_lead')` e um push `cta_whatsapp_click` no `dataLayer`, com a posição do botão.

## Testes A/B pela URL do anúncio

| Parâmetro | Efeito |
|---|---|
| `?h=a` | Os melhores carros saem antes do anúncio (padrão) |
| `?h=b` | Seminovos em Maceió, antes de todo mundo |
| `?h=c` | Cansou de chegar e o carro já ter sido vendido? |
| `?cta=2` | Botões principais viram "Ver os carros primeiro" |

Exemplo: `https://seudominio.com/?h=c&cta=2`
