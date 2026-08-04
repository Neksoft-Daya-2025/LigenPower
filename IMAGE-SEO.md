# Image SEO – Ligen Power® Website

## What’s already in place

### Alt text
- **Product pages** (BMS, Power Inverter, Solar Inverter, Power Battery, Solar Street Light, Electric Cycle): Product images have descriptive `alt` (e.g. "LiGen BMS - 1S", "Ligen Power®- 300", "Evolution Series Electric Cycle", "48W Hybrid Solar Street Light").
- **Homepage**: Main banners have descriptive alt (Grid Inverters, Solar Inverters, Battery Management, Solar Street Light, LIGEN E-WAY Electric Cycle). Logo and remaining banners now have descriptive alt.
- **Blog**: Cards use post title as `alt`. Blog post content images use `alt` from API or figcaption context.
- **Header/footer**: Logo has alt "Ligen Power® - Power Inverters, BMS, Solar Inverter, Electric Cycle India"; mobile logo has "Ligen Power® Logo".

### Lazy loading & dimensions
- **Homepage**: Main content images use `loading="lazy"` and `decoding="async"`; many have `width` and `height` (helps CLS).
- **Product/category pages**: Some images do not yet have `loading="lazy"`; adding it to below-fold images would help performance.

### File names
- Product images use meaningful names (e.g. `bms1.png`, `sslproduct.png`, `gridinverter.png`, `cycleproduct.png`). Some legacy names are generic (e.g. `Banner-21.jpeg`, `Item-1.jpeg`); renaming on next redesign is optional.

---

## Fixes just applied

1. **Header logo**: `alt=""` → `alt="Ligen Power® - Power Inverters, BMS, Solar Inverter, Electric Cycle India"`.
2. **Index banners**: Empty `alt` on Banner-21, Banner-41, Item-1 replaced with short, keyword-aware descriptions (power inverter, solar/e-cycle, green energy).

---

## Optional improvements

1. **Lazy loading**: Add `loading="lazy"` to product grid images and other below-fold images on power-inverter, bms, solar-inverter, power-battery, solar-street-light, electric-cycle.
2. **Width/height**: Add `width` and `height` to key images where you know dimensions to reduce layout shift (CLS).
3. **Blog images**: Ensure each blog post’s featured image and in-content images have unique, descriptive `alt` (e.g. "Ligen Evolution Series e-cycle – handlebar display") when saving posts.
4. **New uploads**: Use descriptive file names (e.g. `ligen-power-300-inverter.jpg`, `evolution-series-electric-cycle.jpg`) and always set `alt` in the CMS or HTML.
5. **WebP**: Serve images in WebP (with JPEG/PNG fallback) where possible to improve speed; can be done at server or build step.

---

## Summary

- **Alt text**: Critical images (logo, homepage banners, product images, category heroes) now have descriptive alt. A few YouTube/video placeholder images still use generic or empty alt in JS; acceptable if they’re replaced by real thumbnails.
- **Lazy loading**: Used on homepage; can be extended to category/product grids.
- **File names**: Product assets are mostly well named; optional to rename generic banners later.

Image SEO is in good shape for ranking and accessibility; the optional items above will strengthen it further.
