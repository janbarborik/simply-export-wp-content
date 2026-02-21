=== Simply Export Your WordPress Content ===
Contributors: janbarborik
Tags: export, rtf, markdown, content, backup, ai, knowledge base, divi
Requires at least: 5.0
Tested up to: 6.7
Requires PHP: 7.4
Stable tag: 1.1.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Export your WordPress pages, posts, and custom post types to clean RTF or Markdown — perfect for AI knowledge bases, translation, and backups.

== Description ==

**Simply Export Your WordPress Content** gives you a fast, clean way to export published content from your WordPress site into a single downloadable file — stripped of all HTML, shortcodes, images, and page-builder markup.

Choose your content types, pick a format, click export. That's it.

= Why use this plugin? =

**Pick exactly what to export**
You decide which content types go into the export file. Pages but not posts? Products but not articles? Just check the boxes. This flexibility makes the plugin useful whether you're running a blog, a shop, or a complex multi-type site.

**Two output formats**

* **RTF** — opens in Microsoft Word, LibreOffice Writer, or any translation tool
* **Markdown** — clean, plain text ready for AI tools, Notion, Obsidian, or GitHub

**Build an AI knowledge base from your website**
This is the killer use case. Export all your content to a single `.md` file, upload it to Google Drive or your AI platform of choice, and connect it to ChatGPT, Claude, Gemini, or any AI assistant. In minutes you have an AI trained on everything on your website — your articles, product descriptions, service pages — all in your own voice.

1. Export → Markdown
2. Upload to Google Drive / Notion / your AI tool
3. Connect to your AI assistant
4. Your AI now knows your entire website

**Clean output**

* Removes Divi shortcodes (all `[et_pb_*]` tags) and all other WordPress shortcodes
* Strips all HTML tags
* Decodes HTML entities
* Collapses excessive whitespace
* Exports only **published** content

**Safe by design**
The plugin is completely read-only. It never writes to or modifies your database. Administrator privileges are required to access the export screen.

= Perfect for =

* Building an AI knowledge base over your own website content
* Preparing content for translation agencies
* Creating offline text backups of your site content
* Migrating content to other platforms (Notion, Obsidian, etc.)
* Bulk-reviewing your published content as plain text

= About the author =

Jan Barborík is an online marketing consultant and educator. For practical guides on growing your business online:

* 🇬🇧 English: [marketingonmyown.com](https://marketingonmyown.com)
* 🇨🇿 Czech: [samsobemarketerem.cz](https://samsobemarketerem.cz)

== Installation ==

1. Upload the plugin folder to `/wp-content/plugins/` or install via **Plugins → Add New → Upload Plugin**
2. Activate the plugin in **Plugins → Installed Plugins**
3. Go to **Tools → Simply Export Content**

== Frequently Asked Questions ==

= Does it export draft or private posts? =
No. Only content with the `publish` status is included.

= Does it work with page builders other than Divi? =
The plugin strips all WordPress shortcodes, not just Divi ones. Block-based builders (Elementor, Beaver Builder, etc.) that store raw HTML in the post content may leave some markup — but the plugin still removes all HTML tags, so the output is clean text.

= Can I export WooCommerce products? =
Yes. WooCommerce products are a custom post type. Check the "Products" checkbox in the export form and they will be included.

= Can I choose multiple content types at once? =
Yes. You can check as many content types as you like.

= What is the difference between RTF and Markdown? =
RTF is best for opening in word processors (Word, LibreOffice). Markdown is a plain-text format widely used in AI tools, documentation platforms, and note-taking apps like Notion and Obsidian.

= Is the plugin safe to use on a live site? =
Yes. The plugin only reads data — it makes no changes to your database or files.

== Screenshots ==

1. The export form — choose content types, include excerpts, and select the output format (RTF or Markdown).

== Changelog ==

= 1.1.0 =
* Added Markdown export format
* Full English admin interface
* Refactored to follow WordPress Coding Standards
* Added informational banner with links to author resources

= 1.0.0 =
* Initial release — RTF export with selectable content types

== Upgrade Notice ==

= 1.1.0 =
Adds Markdown export format and a fully English interface. No database changes — safe to upgrade.
