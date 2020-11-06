# qtracker

[Example Tracking Site](https://zygtech.pl/qtracker/)

PHP and Python written scripts to monitor popularity of chosen places every hour between any range of hours. Uses:
+ [SimpleXLSXGen](https://github.com/shuchkin/simplexlsxgen/)
+ [Chart.js](https://www.chartjs.org/)

Installation:
1. `Clone` or `unpack ZIP` on server in example to `home` folder
2. Edit `qtracker.py` by changing `final URL` of your site and places' `search strings` in lines with `saveid()`
3. Edit `config.php` in folder `qtracker` with `qtracker PATH` and min/max hour (same as further in `CRON`)
4. Copy folder `qtracker` to `Apache` public web folder
5. Run `python3 qtracker.py init` to initialize script
6. Add to `CRON` by running `crontab -e` and adding in example `(Monday - Saturday from 10:00-20:00)` line:
    + `0 10-20 * * 1-6 python3 /home/pi/qtracker/qtracker.py`
7. Open `qtracker URL` in browser and monitor popularity of chosen places

