# Content Crawler Migration

This Drupal 8 module migrates the web page content and media files into a clean
GovCMS instance. This module expects a json input as its source. We use a
third-party plugin to crawl through the site we need to migrate and generate
the json source.

Download and install `Content Crawler` by [Jeremy Graham](https://jez.me) :
 - https://github.com/jez500/content-crawler


## Dependencies

The doghouse content migration module depends on

[migrate_plus](https://www.drupal.org/project/migrate_plus)

and

[migrate_tools](https://www.drupal.org/project/migrate_plus)

Drupal 8 modules. So please note that when you enable this module, it will
also enable those two dependent modules.

## Installation

Create the json source by running the content-crawler and place it somewhere
in your `public://` directory and change the location here on the migration
.yml file.

```
  urls:
      - 'public://path-to-file/<filename>.json'
```

If you have a CSV instead of a json source, you will also need to change here:


```
  data_fetcher_plugin: file
  data_parser_plugin: csv
```

Download the Drupal module to your `docroot/modules/custom` directory
Enable the module and its dependencies:

```
drush en content_crawler_migration
```

## Usage

List all the migrations available:
```
drush migrate-status
```

Execute individual import:
```
drush migrate:import <migration-name>
```

Or you can execute the group and it will execute all the migrations under
that:

```
drush migrate:import --group=<group-name>
```

Check your vanilla GovCMS installation for the migrated content.

## Debugging/Testing and Troubleshooting

[Migrate devel](https://www.drupal.org/project/migrate_devel) module can be
useful for dumping out verbose source and destination info in the terminal.


If you don't have [Config devel](https://www.drupal.org/project/config_devel)
installed and configured, you might need to uninstall and reinstall the
`content_crawler_migration` module every time you make a change to the .yml.

Install the config devel module and add this code snippet to the module info
file:

```
# To re-import below migrations/configs run

`drush cdi content_crawler_migration`

config_devel:
  install:
  - migrate_plus.migration.pages
  - migrate_plus.migration.images
  - migrate_plus.migration.files
  - migrate_plus.migration_group.json_import
```
Then simply add execute this Drush command to re-import the configs:

```
drush cdi content_crawler_migration
```


If you want to rollback your migration:
```
drush migrate-rollback <migration-name>
```

If you ever get your migration conflicted/jammed run this, it will change the
migration status back to Idle.

```
drush migrate-reset-status <migration-name>
