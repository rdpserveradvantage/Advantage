update `inventory` set material='4G ANTENNA 5MTR' where material='Big Antenna 4G LTE 1';

update `inventory` set material='4G ANTENNA 5MTR' where material='Big Antenna 4G LTE 2';

update `inventory` set material='Big GPS Antenna' where material='';

delete FROM `inventory` where material='Big GPS Antenna' and date(created_at)='2023-09-22' and status=1 limit 46
delete FROM `inventory` where material='Big GPS Antenna' and date(created_at)='2023-09-22' and status=1 limit 46;

select material,count(1) from inventory group by material