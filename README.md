# popularitytracker

[Example Tracking Site](https://zygtech.pl/qtracker/)

PHP and Python written scripts to monitor popularity of chosen places every hour between any range of hours. Uses:
2. [SimpleXLSXGen](https://github.com/shuchkin/simplexlsxgen/)
3. [Chart.js](https://www.chartjs.org/)

Installation:
1. `Clone` or `unpack ZIP` on server in example to `home` folder
2. Edit `qtracker.py` by changing final `URL` of your site and place's `search string` in lines with function `saveid()`
3. Copy folder `qtracker` to `Apache/Nginx` public web folder
4. Edit `config.php` in this folder with `qtracker` PATH and min/max hour (same as futher in `CRON`)
5. Run `python3 qtracker.py init` to initialize script
6. Add to `CRON` by running `crontab -e` and adding in example `(Monday - Saturday from 10:00-20:00)` line:
	+ `0 10-20 * * 1-6 python3 /home/pi/qtracker/qtracker.py`
7. Open `qtracker URL` in browser and monitor popularity of any places

