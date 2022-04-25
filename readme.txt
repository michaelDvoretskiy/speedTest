1. composer install
2. configure database connection in 'src\DB.php'
3. run 'php vendor/bin/doctrine orm:schema-tool:update --force' to create DB schema
4. run 'php src/data/seed' to fill tables with data (change it in src/data/sql directory if it is needed)
5. At https://developers.google.com/speed/docs/insights/v5/get-started generate API key and paste it to GoogleApiTest in API_KEY constant
6. run 'php test.php'
7. Make SQL-query to extract data (change testDate value to yours)

select c.name company, p.name product, u.url, tt.testType,
t1.PerformanceScore, t1.PerformanceValue,
t2.FirstContentfulPaintScore, t2.FirstContentfulPaintValue,
t3.TimeToInteractiveScore, t3.TimeToInteractiveValue,
t4.SpeedIndexScore, t4.SpeedIndexValue,
t5.TotalBlockingTimeScore, t5.TotalBlockingTimeValue,
t6.LargestContentfulPaintScore, t6.LargestContentfulPaintValue,
t7.CumulativeLayoutShiftScore, t7.CumulativeLayoutShiftValue
from (select * from company_product_url where url<>'') u
inner join companies c on u.company_id = c.id
inner join products p on u.product_id = p.id
cross join (select distinct testType from test_result where testDate > '2022-04-24') tt
left join
(select r.url_id, r.testType, r.score PerformanceScore, r.displayValue PerformanceValue
from test_result r where r.resTitle = 'Performance' and testDate > '2022-04-24') t1
on u.id = t1.url_id and tt.testType = t1.testType
left join
(select r.url_id, r.testType, r.score FirstContentfulPaintScore, r.displayValue FirstContentfulPaintValue
from test_result r where r.resTitle = 'First Contentful Paint' and testDate > '2022-04-24') t2
on u.id = t2.url_id and tt.testType = t2.testType
left join
(select r.url_id, r.testType, r.score TimeToInteractiveScore, r.displayValue TimeToInteractiveValue
from test_result r where r.resTitle = 'Time to Interactive' and testDate > '2022-04-24') t3
on u.id = t3.url_id and tt.testType = t3.testType
left join
(select r.url_id, r.testType, r.score SpeedIndexScore, r.displayValue SpeedIndexValue
from test_result r where r.resTitle = 'Speed Index' and testDate > '2022-04-24') t4
on u.id = t4.url_id and tt.testType = t4.testType
left join
(select r.url_id, r.testType, r.score TotalBlockingTimeScore, r.displayValue TotalBlockingTimeValue
from test_result r where r.resTitle = 'Total Blocking Time' and testDate > '2022-04-24') t5
on u.id = t5.url_id and tt.testType = t5.testType
left join
(select r.url_id, r.testType, r.score LargestContentfulPaintScore, r.displayValue LargestContentfulPaintValue
from test_result r where r.resTitle = 'Largest Contentful Paint' and testDate > '2022-04-24') t6
on u.id = t6.url_id and tt.testType = t6.testType
left join
(select r.url_id, r.testType, r.score CumulativeLayoutShiftScore, r.displayValue CumulativeLayoutShiftValue
from test_result r where r.resTitle = 'Cumulative Layout Shift' and testDate > '2022-04-24') t7
on u.id = t7.url_id and tt.testType = t7.testType
order by u.id;

Some links to tests and API
https://www.googleapis.com/pagespeedonline/v5/runPagespeed?url=https://quote.getpendella.com/abaa&strategy=mobile
https://developers.google.com/speed/docs/insights/rest/v5/pagespeedapi/runpagespeed?apix_params=%7B%22url%22%3A%22https%3A%2F%2Fquote.getpendella.com%2Fabaa%22%2C%22category%22%3A%5B%22PERFORMANCE%22%5D%2C%22strategy%22%3A%22MOBILE%22%7D
https://pagespeed.web.dev/report?url=https%3A%2F%2Fquote.getpendella.com%2Fabaa&hl=en&form_factor=desktop
