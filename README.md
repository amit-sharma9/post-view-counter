# Post View Counter – WordPress Plugin

**Post View Counter** is a lightweight and efficient WordPress plugin that tracks and displays the number of times each post has been viewed. It is designed to seamlessly integrate with any WordPress theme, with specific support for the Astra theme, and offers a customizable admin settings page for better control.

---

## Live Demo

You can see the plugin in action on the live site:  
[https://amit-sharma.lovestoblog.com/](https://amit-sharma.lovestoblog.com/)

---

## Features

- Automatically increments the view count every time a single post is accessed.
- Stores view counts using WordPress’s native Post Meta API for reliable data storage.
- Displays view counts prominently on single post pages.
- Fully compatible with Astra theme, with a fallback to all other themes.
- Includes an admin settings page allowing customization of the view count label.
- Clean, minimal, and performance-optimized code.

---

## Installation

### Via WordPress Admin Panel

1. Download or clone this repository and zip the folder if needed.
2. In your WordPress dashboard, go to **Plugins → Add New → Upload Plugin**.
3. Upload the zipped plugin file or upload the folder via FTP to `/wp-content/plugins/`.
4. Activate the plugin.
5. Configure settings under **Settings → Post View Counter**.

### Manual Installation

1. Upload the `post-view-counter` folder to the `/wp-content/plugins/` directory on your server.
2. Activate the plugin through the ‘Plugins’ menu in WordPress.
3. Adjust the settings as needed.

---

## How It Works

- The plugin hooks into WordPress’s page loading process to detect single post views.
- It updates a custom post meta key `post_views` incrementing the count for each visit.
- It displays the view count just before the post content or via Astra theme-specific hooks.
- Admin users can modify the label (e.g., "Views") from the plugin’s settings page for better branding or localization.

---

## File Structure

```plaintext
post-view-counter/
├── post-view-counter.php   # Main plugin file containing core functionality and settings page
├── README.md               # This documentation file
