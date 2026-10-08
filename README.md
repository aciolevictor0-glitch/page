# LP Radar do Estoque | Mariana Amorim • Seminovos Importadora

Página única (`index.html`), sem build. Basta subir a pasta em qualquer hospedagem estática (Netlify, Vercel, GitHub Pages, Hostinger).

## Antes de publicar

1. **Link do grupo**: já configurado em `WHATSAPP_GROUP_URL`, no final do `index.html`. Todos os botões usam esse link; se o convite for redefinido no WhatsApp, troque ali.
2. **Foto da Mariana**: `assets/mariana.jpg` (bloco de abertura) e `assets/mariana-avatar.jpg` (recorte do rosto usado nos avatares do hero, da autoridade e do celular). Para trocar, mantenha os nomes dos arquivos.
   - **Entregas (prova social)**: `assets/entrega-1.jpg` a `entrega-5.jpg`, com as placas dos clientes borradas. Para adicionar ou trocar, edite a seção `#clientes` do `index.html`.
3. **Fotos de carro**: `assets/hero.jpg` (VW Nivus, com céu e laterais ampliados), `assets/estoque.jpg` (VW Polo), `assets/oferta.jpg` (Fiat Cronos, no celular), `assets/destaque.jpg` (Fiat Argo, card do hero) e `assets/cta-final.jpg` (VW Nivus, fundo do CTA final). Para trocar, mantenha os nomes dos arquivos.
4. **Pixel / GA4**: cole os scripts no `<head>` (há um comentário marcando o lugar). Todo clique em CTA dispara `fbq('track','Lead')`, `gtag('event','generate_lead')` e um push `cta_whatsapp_click` no `dataLayer`, com a posição do botão.

## Testes A/B pela URL do anúncio

| Parâmetro | Efeito |
|---|---|
| `?h=a` | Os melhores carros saem antes da divulgação (padrão) |
| `?h=b` | Seminovos em Maceió, antes de todo mundo |
| `?h=c` | Cansou de chegar e o carro já ter sido vendido? |
| `?cta=2` | Botões principais viram "Ver os carros primeiro" |

Exemplo: `https://seudominio.com/?h=c&cta=2`
