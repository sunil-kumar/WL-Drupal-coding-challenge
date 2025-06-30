# Gazette Notices Module

This is a custom Drupal 10 module developed as part of a coding challenge. The module consumes a third-party REST API from [The Gazette](https://www.thegazette.co.uk/all-notices/notice/data.json) and displays a list of notices with the following details:

- Title (with a link to the original notice)
- Publish date (formatted as "1 October 2021")
- Content/Description

## Features

- Fetches JSON data from a third-party API.
- Renders a clean, accessible list of notices.
- Uses Drupal best practices for custom module development.
- Includes a custom controller to display the data.

## Requirements

- Drupal 10.x
- Internet access to fetch data from the third-party API

## Installation

1. Clone or copy this module into the `modules/custom` directory of your Drupal installation:

   ```bash
   cd web/modules/custom
   git clone [MODULE_REPO_URL] gazette_notices
