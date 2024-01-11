

CREATE DATABASE wikiDb;
use wikiDb;
CREATE TABLE `categories` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) NOT NULL
);

CREATE TABLE `tags` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) NOT NULL
);

CREATE TABLE `users` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) NOT NULL,
  `phone` VARCHAR(10),
  `email` VARCHAR(255) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `role` TINYINT(1) NOT NULL
);

CREATE TABLE `wikis` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(255) NOT NULL,
  `content` TEXT NOT NULL,
  `categoryId` INT,
  `userId` INT,
  FOREIGN KEY (`categoryId`) REFERENCES `categories`(`id`),
  FOREIGN KEY (`userId`) REFERENCES `users`(`id`)
);

CREATE TABLE `wikitags` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `wikiId` INT,
  `tagId` INT,
  FOREIGN KEY (`wikiId`) REFERENCES `wikis`(`id`),
  FOREIGN KEY (`tagId`) REFERENCES `tags`(`id`)
);

INSERT INTO `categories` (`name`) VALUES
('Art'),
('Culture'),
('Sports'),
('Education'),
('Health'),
('Politics'),
('Economics'),
('Entertainment'),
('Travel'),
('Lifestyle');


INSERT INTO `tags` (`name`) VALUES
('Painting'),
('Literature'),
('Football'),
('Learning'),
('Nutrition'),
('Elections'),
('Finance'),
('Movies'),
('Adventure'),
('Fashion');


INSERT INTO `users` (`name`, `phone`, `email`, `password`, `role`) VALUES
('John Doe', '1234567890', 'john.doe@example.com', 'password123', 1),
('Jane Doe', '9876543210', 'jane.doe@example.com', 'securepass', 2);

ALTER TABLE `wikis`
ADD COLUMN `imgLink` VARCHAR(255);


INSERT INTO `wikis` (`title`, `content`, `categoryId`, `userId`, `imgLink`) VALUES
('Introduction to Programming', 'This wiki covers the basics of programming.', 1, 1, 'https://example.com/image1.jpg'),
('Ecosystems and Biodiversity', 'Exploring the importance of biodiversity in ecosystems.', 2, 2, 'https://example.com/image2.jpg'),
('Renewable Energy Technologies', 'An overview of various renewable energy technologies.', 3, 1, 'https://example.com/image3.jpg'),
('Medieval Kings and Queens', 'A historical account of medieval rulers and their reigns.', 4, 2, 'https://example.com/image4.jpg');

INSERT INTO `wikitags` (`wikiId`, `tagId`) VALUES
(1, 1),
(1, 3),
(2, 2),
(3, 1),
(3, 3),
(4, 4);
