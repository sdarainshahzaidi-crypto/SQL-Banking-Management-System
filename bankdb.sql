Drop Database BankDB;
CREATE DATABASE BankDB;
USE BankDB;
drop TABLE Customer;
CREATE TABLE Customer (
    customer_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    phone VARCHAR(15),
    address VARCHAR(100)
);
INSERT INTO Customer (name, phone, address) VALUES
('Ali Khan','03001234567','Lahore'),
('Ahmed Raza','03011234567','Karachi'),
('Usman Ali','03021234567','Islamabad'),
('Hassan Ahmed','03031234567','Faisalabad'),
('Bilal Hussain','03041234567','Multan'),
('Zain Malik','03051234567','Rawalpindi'),
('Saad Khan','03061234567','Sialkot'),
('Hamza Tariq','03071234567','Gujranwala'),
('Umar Farooq','03081234567','Peshawar'),
('Talha Iqbal','03091234567','Quetta'),
('Awais Ali','03101234567','Lahore'),
('Imran Khan','03111234567','Karachi'),
('Shahid Afridi','03121234567','Islamabad'),
('Babar Azam','03131234567','Lahore'),
('Rizwan Ahmed','03141234567','Peshawar'),
('Fakhar Zaman','03151234567','Mardan'),
('Sarfaraz Ahmed','03161234567','Karachi'),
('Naseem Shah','03171234567','Quetta'),
('Shaheen Afridi','03181234567','Lahore'),
('Haris Rauf','03191234567','Rawalpindi');
SELECT* from Customer;
drop TABLE Branch;
CREATE TABLE Branch (
    branch_id INT AUTO_INCREMENT PRIMARY KEY,
    branch_name VARCHAR(100),
    branch_city VARCHAR(100)
);
INSERT INTO Branch (branch_name, branch_city) VALUES
('Main Branch','Lahore'),
('City Branch','Karachi'),
('Capital Branch','Islamabad'),
('North Branch','Peshawar'),
('South Branch','Multan');
select * from branch;

SELECT Account.account_id, Branch.branch_name, Branch.branch_city
FROM Account
JOIN Branch
ON Account.branch_id = Branch.branch_id;

drop TABLE Account;
CREATE TABLE Account (
    account_id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT,
    branch_id INT,
    account_type VARCHAR(20),
    balance INT,
    FOREIGN KEY (customer_id) REFERENCES Customer(customer_id),
    FOREIGN KEY (branch_id) REFERENCES Branch(branch_id)
);
INSERT INTO Account (customer_id, branch_id, account_type, balance) VALUES
(1,1,'Savings',5000),(2,2,'Current',8000),(3,3,'Savings',6000),
(4,1,'Current',7000),(5,5,'Savings',4000),(6,2,'Current',9000),
(7,4,'Savings',3000),(8,1,'Current',7500),(9,4,'Savings',6500),
(10,3,'Current',5500),(11,1,'Savings',4500),(12,2,'Current',8500),
(13,3,'Savings',6200),(14,1,'Current',10000),(15,4,'Savings',7200),
(16,4,'Current',8100),(17,2,'Savings',5300),(18,5,'Current',4700),
(19,1,'Savings',9200),(20,2,'Current',8800);
Select * from Account;

SELECT Customer.name, Account.account_id, Account.balance
FROM Customer
JOIN Account
ON Customer.customer_id = Account.customer_id;


CREATE TABLE Transactions (
    transaction_id INT AUTO_INCREMENT PRIMARY KEY,
    account_id INT,
    transaction_type VARCHAR(20),
    amount INT,
    transaction_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (account_id) REFERENCES Account(account_id)
);
INSERT INTO Transactions (account_id, transaction_type, amount) VALUES
(1,'Deposit',1000),(2,'Withdraw',500),(3,'Deposit',1500),
(4,'Withdraw',700),(5,'Deposit',2000),(6,'Withdraw',1000),
(7,'Deposit',1200),(8,'Withdraw',800),(9,'Deposit',900),
(10,'Withdraw',400),(11,'Deposit',1100),(12,'Withdraw',600),
(13,'Deposit',1300),(14,'Withdraw',1000),(15,'Deposit',1400),
(16,'Withdraw',900),(17,'Deposit',1600),(18,'Withdraw',300),
(19,'Deposit',1700),(20,'Withdraw',500);
Select * from Transactions;

SELECT Account.account_id, Transactions.transaction_type, Transactions.amount
FROM Account
JOIN Transactions
ON Account.account_id = Transactions.account_id;

drop TABLE Employee;
CREATE TABLE Employee (
    employee_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    position VARCHAR(50),
    branch_id INT,
    FOREIGN KEY (branch_id) REFERENCES Branch(branch_id)
);
INSERT INTO Employee (name, position, branch_id) VALUES
('Ali Raza','Manager',1),
('Usman Tariq','Cashier',1),
('Hassan Ali','Clerk',2),
('Bilal Ahmed','Manager',2),
('Zain Khan','Cashier',3),
('Saad Ali','Clerk',3),
('Hamza Khan','Manager',4),
('Umar Tariq','Cashier',4),
('Talha Raza','Clerk',5),
('Awais Khan','Manager',5);
Select * from Employee;
SELECT Employee.name, Employee.position, Branch.branch_name
FROM Employee
JOIN Branch
ON Employee.branch_id = Branch.branch_id;

CREATE TABLE Loan (
    loan_id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT,
    loan_amount INT,
    loan_type VARCHAR(50),
    FOREIGN KEY (customer_id) REFERENCES Customer(customer_id)
);
INSERT INTO Loan (customer_id, loan_amount, loan_type) VALUES
(1,50000,'Home'),
(3,30000,'Car'),
(5,20000,'Personal'),
(7,40000,'Business'),
(10,25000,'Education'),
(12,35000,'Car'),
(15,45000,'Home'),
(18,15000,'Personal');
select * from Loan;
SELECT Customer.name, Loan.loan_amount, Loan.loan_type
FROM Customer
JOIN Loan
ON Customer.customer_id = Loan.customer_id;
CREATE TABLE Card (
    card_id INT AUTO_INCREMENT PRIMARY KEY,
    account_id INT,
    card_type VARCHAR(20),
    expiry_date DATE,
    FOREIGN KEY (account_id) REFERENCES Account(account_id)
);
INSERT INTO Card (account_id, card_type, expiry_date) VALUES
(1,'Debit','2028-05-01'),
(2,'Credit','2027-08-15'),
(3,'Debit','2029-01-10'),
(4,'Credit','2026-12-20'),
(5,'Debit','2028-03-11'),
(6,'Credit','2027-07-07'),
(7,'Debit','2029-09-09'),
(8,'Credit','2026-11-11'),
(9,'Debit','2028-06-06'),
(10,'Credit','2027-04-04');
Select * from Card;

UPDATE Account
SET balance = 12000
WHERE account_id = 1;
select* from Account;

DELETE FROM Transactions
WHERE transaction_id = 10;
select * from Transactions;

SELECT * FROM Account
ORDER BY balance DESC;

SELECT branch_id, COUNT(account_id) AS total_accounts
FROM Account
GROUP BY branch_id;

SELECT SUM(balance) AS Total_Balance
FROM Account;

SELECT MAX(balance) AS Highest_Balance
FROM Account;

SELECT MIN(balance) AS Lowest_Balance
FROM Account;

SELECT AVG(balance) AS Average_Balance
FROM Account;

SELECT Customer.customer_id, Customer.name, Account.account_id, Account.balance
FROM Customer
INNER JOIN Account
ON Customer.customer_id = Account.customer_id;

SELECT Customer.customer_id, Customer.name, Account.account_id, Account.balance
FROM Customer
LEFT JOIN Account
ON Customer.customer_id = Account.customer_id;

SELECT Customer.name, Account.account_id, Account.balance
FROM Customer
RIGHT JOIN Account
ON Customer.customer_id = Account.customer_id;

SELECT Customer.name, Account.account_id
FROM Customer
CROSS JOIN Account;

