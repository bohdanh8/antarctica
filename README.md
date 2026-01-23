<p align="center">
  <img src="https://prosek-wp-updater.s3.us-east-2.amazonaws.com/assets/banner-1544x500.jpg" alt="Prosek Starter WP Theme Banner" width="100%">
</p>

# Prosek Starter Theme Framework for WordPress

The **Prosek Starter Theme Framework** is a customizable and scalable starting point for WordPress theme development.

---

## 📦 Google Fonts Integration

You can download Google Fonts via [google-webfonts-helper](https://gwfh.mranftl.com/fonts) for use in your theme setup.

---

## 🛠️ Setup Instructions

```bash
# 1. Clone the repository
$ git clone https://your-repo-url.com

# 2. Navigate into the theme directory
$ cd your-theme-directory

# 3. Install dependencies and create local config files
$ npm install
```

> 📎 This will also copy `webpack-sample.config.js` and `debug-sample-config.php` into the `config/` folder if they do not already exist.

```bash
# 4. Start local development with hot reloading, if enabled
$ npm run dev

# 5. Build production assets
$ npm run build

# 6. Sync ACF JSON fields after pulling updates
$ npm run copy-acf

# 7. Clean the dist folder manually (optional)
$ npm run clean
```

-   Use `theme-config.php` to manage environment-level constants.
-   For automatic file transfer to staging (via GitHub Actions), ensure `uploadToStaging` is enabled.
-   For hot reloading, ensure `browsersyncEnabled` is enabled.

---

## 📃 Changelog

### [1.0.0] - 14 Aug 2023

-   Initial release.

### [1.0.1] - 18 Aug 2023

-   Fixed height issue on desktop-only screens.
-   Added workspace stubs.
-   Excluded certain folders from text searches.
-   Disabled overscroll and removed image styling.
-   Upgraded image rendering engine to include scaling.
-   Fixed image styling issues.
-   Labeled files in modules folder as **_ DO NOT EDIT _**.

### [1.0.2] - 18 Aug 2023

-   Removed favicons so they are pulled from WP.
-   Added Google Webfonts Helper link.

### [1.0.3] - 19 Aug 2023

-   Prevented \_filename.php files outside src from being added to dist.

### [1.0.4] - 22 Aug 2023

-   Added quick server upload disable feature.

### [1.0.5] - 27 Aug 2023

-   Image object-fit set to 'contain' if ACF simple image field used.

### [1.0.6] - 29 Aug 2023

-   Fixed webpack build error.
-   Moved modules and entry file to inc/js.
-   Git-ignored webpack config file.

### [1.0.7] - 30 Aug 2023

-   Refined Modal module and added documentation.

### [1.0.8] - 31 Aug 2023

-   Fixed MIN_SCREEN_SIZE bug.
-   Added modal event triggers and keepHidden option.
-   Removed overscroll.

### [1.0.9] - 1 Sep 2023

-   Added version to style.css.
-   Set server upload to true.

### [1.0.10] - 6 Sep 2023

-   Modal inline CSS resize fix.
-   Added Header & Footer module.
-   Modal bug fixes.

### [1.0.11] - 7 Sep 2023

-   Modal CSS-based open/close.
-   Added more event triggers.
-   Escape key fix in Safari.

### [1.0.12] - 10 Sep 2023

-   Backdrop click closes modal.
-   Reset GForm on modal close.

### [1.0.13] - 13 Sep 2023

-   Minification fix.
-   Extended ACF shortcode and enabled GF shortcodes.

### [1.0.14] - 14 Sep 2023

-   Added render_background_image() for standard ACF images.

### [1.0.15] - 15 Sep 2023

-   WooCommerce and GF stubs for autocomplete.

### [1.0.16] - 21 Sep 2023

-   Allowed <img> width override in render_image().

### [1.0.17] - 26 Sep 2023

-   DISABLE_PARENTS_FOR_TERMS config added.

### [1.0.18] - 26 Sep 2023

-   BrowserSync hot reload enabled.

### [1.0.19] - 28 Sep 2023

-   Fixed intermittent build loop.

### [1.0.20] - 28 Sep 2023

-   Separated constants and removed parent term dropdown.

### [1.0.21] - 3 Oct 2023

-   Fixed PHP deprecated warning.

### [1.0.22] - 6 Oct 2023

-   Added debug_log() for variable debugging.

### [1.0.23] - 8 Oct 2023

-   Fixed rendering issue for message-only ACF sections.

### [1.0.24] - 18 Oct 2023

-   Excluded dist/bin from repo.
-   Temporarily disabled staging upload.

### [1.0.25] - 19 Oct 2023

-   Added Document Restriction feature.

### [1.0.26] - 31 Oct 2023

-   Improved image loader performance.
-   Fixed blurry images in dynamic DOM.

### [1.0.27] - 1 Nov 2023

-   Added toggle to rename 'Post' to 'News'.

### [1.0.28] - 4 Nov 2023

-   Excluded all \_filename.php from build.

### [1.1.0] - 10 Nov 2023

-   Added Content Restriction feature.

### [1.2.0] - 29 Nov 2023

-   Added WPGB stub, meta search override, new modules.

### [1.3.0] - 7 Dec 2023

-   ACF textarea as post excerpt support.

### [1.3.1] - 11 Dec 2023

-   Updated search filter anchor ID.
-   Moved version number.

### [1.3.2] - 13 Dec 2023

-   Extended document type support.
-   Added nested group support.

### [1.4.0] - 27 Feb 2024

-   Refactored Webpack config.
-   Set uploadToStaging true by default.

### [1.4.1] - 28 Apr 2024

-   CI/CD for Pressable via GitHub Actions.

### [1.4.2] - 10 May 2024

-   Fixed wrapper conflict with wp_get_attachment_image().
-   Added CSS override param.

### [1.4.3] - 17 Jun 2024

-   Improved image performance.
-   Removed background image for non-render_image().

### [1.4.4] - 21 Jun 2024

-   Restored default blur/duration in image module.

### [1.5.0] - 7 Jul 2024

-   WPGB events for custom script triggers.

### [1.6.0] - 9 Jul 2024

-   Added wpgbappended event.

### [1.6.1] - 10 Jul 2024

-   Modal wrapper added to body by default.

### [1.6.2] - 11 Jul 2024

-   Firefox modal fadeIn fix.

### [1.6.3] - 6 Sep 2024

-   Header/Footer load-time height calculation.

### [1.6.4] - 9 Sep 2024

-   Modal debug flag added.
-   Prevented multiple modal toggles.

### [1.6.5] - 23 Sep 2024

-   Permanent fix for Firefox modal issue.

### [1.6.6] - 10 Oct 2024

-   Fixed Post/Page preview ACF issue.

### [1.6.7] - 3 Nov 2024

-   Optimized render_image() for screen-width.

### [1.6.8] - 20 Dec 2024

-   Fixed section rendering when disabled.

### [1.6.9] - 11 Feb 2025

-   Added reusable ACF sections and utilities.

### [1.6.10] - 27 Feb 2025

-   Limited image-loader to render_image().
-   Post revision fix.

### [1.6.10.1] - 18 Mar 2025

-   Fixed acf-json copy issue.

### [1.6.10.2] - 3 Apr 2025

-   Fixed conflict with .github/workflows/main.yml copy.

### [1.6.11] - 15 Apr 2025

-   Excluded .localize.js files from import.
-   Handled wp_localize_script() files.

### [1.7.0] - 30 Apr 2025

-   Added Peacock to the list of recommended extensions and set a default colour for the VS Code workspace. This can be customised per project to help visually distinguish between different IDE setups.
-   Cleaned up the ACF JSON copy functionality to simplify the process and ensure backward compatibility. The additional `acf-copy` script and its dependency on the `0_utils.js` file have been removed. With this update, if an `acf-json` folder does not exist in either the main repository or the local theme (within the local WordPress installation), `npm run dev/build` will function as before. If only the local theme contains the `acf-json` folder, it will be copied to the repository. Conversely, if only the repository contains the `acf-json` folder, it will be copied to the local theme. If both locations contain an `acf-json` folder, the repository version will be replaced by the one in the local theme.

### [1.7.1] - 30 Jun 2025

-   Extended Accordion functionality to allow for full library functionality.
-   Added Media variant for button component (Allows to select PDF file from the Media Library).
-   Added a Media Element component, which is used to output image or video using ACF fields. In the case of video, you can output both for the background and for playback in the player.
-   Menu icon replaced with universal component. Now you just need to specify it size.
-   Fixed header height calculation on resize.
-   Extended Scroll Animation to handle ease-btm different offset.
-   Fixed "Load More" functionality when Load More button could appear twice.
-   Theme updated with Tailwind 3.4.17.
-   Added styles for Gravity Forms.
-   Updated styles for CookieYes plugin.
-   Filtration (filter_dropdown.php) updated with new `buttons` layout. For add `'layout' => 'buttons'` in `get_component` `$args`.
-   Added Share Links modal. Added Native share button. Added Copy share button
-   Created "General Page" section for simple created pages.
-   Implemented WPGB Filtration plugin on BLog and Team pages
-   Added Media Element to Text + Image section
-   Added demo elements appearance animation on scroll

---
