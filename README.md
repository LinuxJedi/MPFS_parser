# MPFS_parser
A desktop parser for Microchip PIC MPFS html

## Prerequisites

This tool requires Linux or Mac OS X

PHP's command line parser is required, Macs have this installed by default.  In Ubuntu this can be installed using

```bash
sudo apt-get install php5-cli
```

## How to use

* Copy the `render.php` and `runme.sh` file to the directory of the HTML files
* Create a file called `replacements.ini` in the directory of the HTML files with the variables you wish to replace such as

```ini
variable=value
```

* Run `./runme.sh`
* Go to `http://localhost:8000` in your web browser
