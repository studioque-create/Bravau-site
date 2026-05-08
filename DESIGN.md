# DESIGN.md — Bravau Auditores
**Brand:** Bravau Auditores  
**Segment:** Audit · Accounting · Consulting — Enterprise  
**Positioning:** Big Four standard, accessible to mid-market companies  
**Credentials:** Certificados pelo Banco Central e CVM · IFRS · CPC · US GAAP

---

## 1. Visual Theme & Atmosphere

**Mood:** Institutional authority. Dense, deliberate, zero decorative noise.  
**Aesthetic:** Premium corporate — the visual weight of a Big Four firm distilled into a Brazilian mid-market context. Every element earns its place. Nothing is decorative. Everything communicates competence and control.  
**Density:** Low content density per screen. Generous whitespace. Let statements breathe.  
**Feeling:** The page should feel like walking into a well-run boardroom — not a startup landing page.

---

## 2. Color Palette & Roles

| Name | Hex | Role |
|---|---|---|
| Deep Onyx | `#1A1A1A` | Primary background. Full-bleed sections. The base. |
| Charcoal | `#222222` | Secondary background. Cards, panels, elevated surfaces. |
| Surface Dark | `#2A2A2A` | Subtle card background, hover states. |
| Bravau Gold | `#C9A84C` | Primary accent. CTAs, borders, labels, logo mark. |
| Gold Muted | `#A8893D` | Hover state for gold elements. Secondary accent use. |
| Gold Dim | `#6B5A2A` | Decorative geometric shapes, background motifs, concentric rings. |
| Pure White | `#FFFFFF` | Primary headline text on dark backgrounds. |
| Off-White | `#F0EDE8` | Body text, secondary text on dark backgrounds. |
| Warm Gray | `#9A9A8A` | Tertiary text, metadata, footnotes, legal copy. |
| Gold Border | `#C9A84C` | Section dividers, card borders, logo frame. |

**Never use:** Blues, greens, or reds as brand colors. Never use white backgrounds — the brand lives on dark.

---

## 3. Typography Rules

### Headline Font
**Family:** Georgia, "Times New Roman", serif (system serif stack)  
**Weight:** Bold (700) for all primary headlines  
**Style:** Large, commanding. Headlines are statements, not titles.  
**Letter-spacing:** -0.02em (slightly tight — adds gravitas)  
**Line-height:** 1.1 for display headlines, 1.3 for section headlines  
**Color:** `#FFFFFF`

### Subheadline / Lead
**Family:** Georgia, serif  
**Weight:** Regular (400), italic  
**Color:** `#F0EDE8`  
**Line-height:** 1.5

### Body Text
**Family:** "Inter", "Helvetica Neue", Arial, sans-serif  
**Weight:** 300–400  
**Size:** 16–18px  
**Color:** `#F0EDE8`  
**Line-height:** 1.7

### Labels / Eyebrows
**Family:** Inter, sans-serif  
**Weight:** 600  
**Size:** 11–12px  
**Letter-spacing:** 0.15em (wide tracking — institutional feel)  
**Transform:** UPPERCASE  
**Color:** `#C9A84C`  
**Usage:** Section identifiers above headlines ("O PROBLEMA", "A SOLUÇÃO", "AUDITORIA CONSULTIVA")

### Metadata / Legal
**Family:** Inter, sans-serif  
**Weight:** 300  
**Size:** 12–13px  
**Color:** `#9A9A8A`  
**Usage:** Certifications bar, footnotes ("Certificados pelo Banco Central e CVM · IFRS · CPC · US GAAP")

### Numbers / Metrics
**Family:** Georgia, serif  
**Weight:** Bold  
**Size:** 48–72px  
**Color:** `#C9A84C` (gold numbers = proven results)  
**Usage:** KPI callouts (−68%, +37%, 0 ressalvas)

---

## 4. Component Styling

### Buttons — Primary CTA
- Background: `#C9A84C`
- Text: `#1A1A1A` (dark on gold)
- Font: Inter, 600, 11px, letter-spacing 0.15em, UPPERCASE
- Padding: 14px 32px
- Border-radius: 0px (sharp corners — institutional, not startup)
- Hover: background `#A8893D`
- No shadows, no gradients

### Buttons — Secondary / Ghost
- Background: transparent
- Border: 1px solid `#C9A84C`
- Text: `#C9A84C`
- Same font rules as primary
- Hover: background `rgba(201, 168, 76, 0.08)`

### Cards / Service Panels
- Background: `#222222`
- Border-top: 3px solid `#C9A84C` (gold top accent)
- Border-radius: 0px
- Padding: 40px 32px
- No drop shadows — use subtle border instead
- Hover: background `#2A2A2A`, border-top color stays gold

### Section Labels (Eyebrow Tags)
- Background: `#C9A84C`
- Text: `#1A1A1A`
- Font: Inter 600, 10px, letter-spacing 0.2em, UPPERCASE
- Padding: 6px 16px
- Border-radius: 0px
- Display: inline-block, above the headline

### Dividers / Separators
- Color: `#C9A84C`
- Thickness: 1px
- Opacity: 0.3 for subtle, 1.0 for structural

### Metric Callouts (KPI blocks)
- Number: Georgia Bold, 56–72px, `#C9A84C`
- Label below: Inter 300, 13px, `#9A9A8A`, letter-spacing 0.1em
- No card background — float on section background
- Alignment: left or center depending on context

### Navigation
- Background: `#1A1A1A` with `border-bottom: 1px solid rgba(201, 168, 76, 0.2)`
- Logo: left-aligned
- Links: Inter 400, 14px, `#F0EDE8`, letter-spacing 0.05em
- Active/hover link: `#C9A84C`
- CTA in nav: Primary button style (gold filled)
- Position: sticky, full-width

### Logo Treatment
- "Brav" in white, "Au" in gold — always respect this split
- Surrounded by a thin gold rectangular border
- Tagline: "AUDIT | ACCOUNTING | CONSULTING" in Inter 300, tracking wide, `#9A9A8A`
- Minimum clear space: equal to height of the "A" in BravAu on all sides

---

## 5. Layout Principles

### Grid
- Max content width: 1200px, centered
- Columns: 12-column grid, 24px gutters
- Primary layout: 55/45 split (text left, visual/geometric right) for hero sections
- Full-bleed dark sections with contained content columns

### Spacing Scale (8px base)
- xs: 8px
- sm: 16px
- md: 24px
- lg: 40px
- xl: 64px
- 2xl: 96px
- 3xl: 128px

### Section Structure
Each section follows: **label → headline → supporting copy → evidence → CTA**  
Never skip the label. Never lead with body text. The headline must be a provocation or statement.

### Whitespace Philosophy
Generous. The brand is premium — crowding is a signal of insecurity. Sections should have 80–120px vertical padding minimum. Let the headline dominate.

### Visual Motif — Concentric Geometry
- Concentric circles or concentric diamond shapes as background decoration
- Color: `#6B5A2A` to `#2A2A2A` gradients — very subtle, never loud
- Placed in the right 40–50% of hero/feature sections
- Opacity: 0.4–0.7 — always behind content, never competing
- This is the brand's visual signature — use consistently

---

## 6. Tone of Voice (for microcopy and UI text)

- **Direct and declarative.** Not "We can help you reduce taxes." → "Redução de 10% a 30% na carga tributária."
- **Provocative headlines.** Name the problem before offering the solution.
- **No jargon without context.** IFRS, CPC, US GAAP are used — always paired with what they mean for the client.
- **Numbers anchor credibility.** Always quantify results: −68%, +37%, 0 ressalvas.
- **Never use:** "innovative", "synergy", "holistic", "solutions provider", or any generic B2B filler.
- **CTA language:** "A conversa é gratuita." / "Fale com um especialista" / "Diagnóstico sem compromisso"

---

## 7. Do / Don't Rules

**DO:**
- Use serif bold for all display headlines
- Keep backgrounds dark — the brand lives in dark mode
- Lead every section with a gold uppercase label
- Use gold exclusively for emphasis — never decoratively
- Place geometric motifs in right-side panels, behind content
- Quantify every claim with a metric
- Use sharp corners (border-radius: 0) on all interactive elements

**DON'T:**
- Don't use white or light backgrounds anywhere
- Don't round corners on buttons or cards
- Don't use more than 2 font families (Georgia + Inter)
- Don't use gold for body text or large blocks of copy
- Don't add drop shadows — they weaken the institutional feel
- Don't use stock photos of handshakes, charts, or generic office imagery
- Don't animate gratuitously — subtle fade-ins only, no parallax, no bouncing

---

## 8. Services Reference (for content generation)

| Service | Tagline | Section Label |
|---|---|---|
| Adequação à Reforma Tributária | "Prepare-se antes que seja tarde" | SERVIÇO DE ENTRADA |
| Estruturação do Negócio | "Base sólida para crescer certo" | FUNDAÇÃO |
| Auditoria Consultiva | "Sem surpresas na hora H" | CONFORMIDADE |
| Implantação de ERP | "Seu sistema trabalhando por você" | TECNOLOGIA |
| Gestão para Criação de Valor | "Lucro virou riqueza real" | CRESCIMENTO |

---

## 9. Quality Gates

Before shipping any UI component or page, verify:

- [ ] Background is dark (`#1A1A1A` or `#222222`) — never white
- [ ] Every section has a gold uppercase label above the headline
- [ ] Headlines are Georgia Bold, white, with tight letter-spacing
- [ ] All buttons and cards have `border-radius: 0`
- [ ] At least one metric (number in gold) per major section
- [ ] Geometric concentric motif present in hero/feature sections
- [ ] Footer includes: "Certificados pelo Banco Central e CVM · IFRS · CPC · US GAAP"
- [ ] No generic stock imagery
- [ ] CTA copy matches brand voice (direct, no fluff)
- [ ] Mobile: headlines scale down gracefully, gold labels remain visible
