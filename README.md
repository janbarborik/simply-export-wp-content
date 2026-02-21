# Simply Export Your WordPress Content

A lightweight WordPress plugin that exports your published content — pages, posts, and custom post types — into clean **RTF** or **Markdown** files. All shortcodes, HTML tags, images, and iframes are stripped automatically, leaving you with pure, readable text.

---

## Why You'll Love It

### Choose Exactly What to Export
Unlike generic export tools, this plugin lets you **pick individual content types**. Exporting a blog but not the shop product pages? No problem. Just check the boxes you need — pages, posts, WooCommerce products, custom post types, anything.

### Two Output Formats
| Format | Best for |
|--------|----------|
| **RTF** | Microsoft Word, LibreOffice Writer, translation tools |
| **Markdown** | AI tools, Notion, Obsidian, GitHub, knowledge bases |

### Build an AI Knowledge Base from Your Website
This is where the plugin truly shines. Export all your content to a single Markdown file, upload it to **Google Drive** or any knowledge base tool, and connect it to your AI assistant (ChatGPT, Claude, Gemini, etc.). In minutes you have an AI that knows everything on your website — and can answer questions about your products, services, or articles.

**Workflow:**
1. Export → Markdown
2. Upload `.md` file to Google Drive / Notion / your AI tool
3. Connect the document to your AI assistant
4. Done — your AI now speaks with your voice

### Clean Output, Every Time
- Strips **Divi** shortcodes (and all other shortcodes)
- Removes all HTML markup
- Removes images and iframes
- Decodes HTML entities
- Collapses excessive whitespace

### Safe by Design
The plugin is **read-only** — it never writes to or modifies your database.

---

## Installation

1. Download the plugin (`.zip` or the raw `.php` file)
2. Go to **WordPress Admin → Plugins → Add New → Upload Plugin**
3. Activate the plugin
4. Navigate to **Tools → Simply Export Content**

### Manual installation
```
wp-content/
  plugins/
    simply-export-wp-content/
      wp-content-exporter.php
```

---

## Usage

1. Go to **Tools → Simply Export Content** in your WordPress admin
2. Tick the content types you want to export
3. Optionally include excerpts
4. Choose the output format: **RTF** or **Markdown**
5. Click **Export Content** — the file downloads immediately

---

## Requirements

- WordPress 5.0 or higher
- PHP 7.4 or higher

---

## Screenshots

_(Screenshots will be added once the plugin is listed on WordPress.org)_

---

## Frequently Asked Questions

**Does it export draft or private posts?**
No — only published content is included.

**Will it work with page builders other than Divi?**
The plugin strips all shortcodes (not just Divi), so most page-builder markup is removed. Results may vary with block-based builders like Elementor that store HTML in the post content.

**Can I export WooCommerce products?**
Yes. WooCommerce products are a custom post type — just check the "Products" checkbox in the export form.

**Is the plugin safe?**
Yes. It only reads from the database and never modifies anything. It requires administrator privileges to use.

---

## Changelog

### 1.1.0
- Added Markdown export format
- Translated entire admin interface to English
- Refactored codebase for WordPress Coding Standards compliance
- Added marketing information banner

### 1.0.0
- Initial release — RTF export with content type selection

---

## License

GPL v2 or later — [https://www.gnu.org/licenses/gpl-2.0.html](https://www.gnu.org/licenses/gpl-2.0.html)

---

## About the Author

**Jan Barborík** — online marketing consultant and educator.

If this plugin saved you time, check out more practical tips on building your online presence without an agency:

| | |
|---|---|
| 🇬🇧 **English** | [marketingonmyown.com](https://marketingonmyown.com) |
| 🇨🇿 **Czech** | [samsobemarketerem.cz](https://samsobemarketerem.cz) |

Topics covered: content marketing, AI tools for marketers, SEO, social media strategy, building websites that actually convert.
