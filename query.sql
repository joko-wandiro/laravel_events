SELECT * FROM users;

SELECT * FROM events;

SELECT * FROM event_tags;

SELECT * FROM organizers;

SELECT * FROM orders 
ORDER BY id DESC;

SELECT * FROM order_products 
ORDER BY id_order DESC;
<<<<<<< HEAD

SELECT * FROM order_detail 
ORDER BY id DESC;
=======
>>>>>>> 16bc49aefba40f8cb9a5ab5fb05f63eda38186f1

SELECT * FROM settings;

select `orders`.`id`, `orders`.`date`, `orders`.`paid`, `orders`.`change`, `order_products`.* from `orders` 
INNER join `order_products` on `order_products`.`id_order` = `orders`.`id` 
where `id` = 15;

SELECT npm, DATE_FORMAT(date, '%M-%Y') AS bulan_tahun, COUNT(id) AS total FROM kehadiran 
GROUP BY npm, bulan_tahun;

SELECT * FROM orders 
ORDER BY id DESC;

-- Start Report daily
SELECT DATE_FORMAT(date, '%Y-%m') AS monthyear, DATE_FORMAT(orders.date, '%d') AS date, users.name, 
COUNT(orders.id) AS total_order, SUM(orders.total) AS total FROM orders 
INNER JOIN users ON users.id = orders.id_user 
GROUP BY DATE_FORMAT(orders.date, '%Y-%m-%d') 
HAVING monthyear = DATE_FORMAT(DATE_SUB(NOW(), INTERVAL 0 MONTH), '%Y-%m');
-- End Report daily

-- Start Report monthly
SELECT DATE_FORMAT(date, '%Y') AS year, DATE_FORMAT(orders.date, '%m') AS month, users.name, 
COUNT(orders.id) AS total_order, SUM(orders.total) AS total FROM orders 
INNER JOIN users ON users.id = orders.id_user 
GROUP BY DATE_FORMAT(orders.date, '%Y-%m') 
HAVING year = DATE_FORMAT(DATE_SUB(NOW(), INTERVAL 0 YEAR), '%Y');
-- End Report monthly

-- Total sales
SELECT COUNT(orders.id) AS total_order, SUM(orders.total) AS total FROM orders;
-- INNER JOIN users ON users.id = orders.id_user;
-- GROUP BY DATE_FORMAT(orders.date, '%Y-%m') 
-- HAVING year = DATE_FORMAT(DATE_SUB(NOW(), INTERVAL 0 YEAR), '%Y');

SELECT DATE_SUB('2008-02-02', INTERVAL 1 MONTH);
SELECT DATE_SUB(NOW(), INTERVAL 0 YEAR);

select DATE_FORMAT(date, '%Y') AS year, DATE_FORMAT(orders.date, '%m') AS month, `users`.`name`, 
COUNT(orders.id) AS total_order, SUM(orders.total) AS total from `orders` 
INNER join `users` on `users`.`id` = `orders`.`id_user` 
group by DATE_FORMAT(orders.date, '%Y-%m') 
having `year` = '2019';

UPDATE orders SET id_customer = 1;