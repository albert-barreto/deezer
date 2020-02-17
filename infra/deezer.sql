-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3307
-- Generation Time: Feb 17, 2020 at 01:21 PM
-- Server version: 8.0.18
-- PHP Version: 7.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `deezer`
--
CREATE DATABASE IF NOT EXISTS `deezer` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `deezer`;

-- --------------------------------------------------------

--
-- Table structure for table `album`
--

CREATE TABLE `album` (
                         `id` int(11) NOT NULL,
                         `title` varchar(45) DEFAULT NULL,
                         `year` int(11) DEFAULT NULL,
                         `artist_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `album`
--

INSERT INTO `album` (`id`, `title`, `year`, `artist_id`) VALUES
(1, 'Album 1', 2017, 1),
(2, 'Album 2', 2018, 2),
(3, 'Album 3', 2018, 3),
(4, 'Album 4', 2019, 1);

-- --------------------------------------------------------

--
-- Table structure for table `artist`
--

CREATE TABLE `artist` (
                          `id` int(11) NOT NULL,
                          `name` varchar(45) DEFAULT NULL,
                          `style` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `artist`
--

INSERT INTO `artist` (`id`, `name`, `style`) VALUES
(1, 'Artist 1', 'rock'),
(2, 'Artist 2', 'pop'),
(3, 'Artist 3', 'jazz');

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
                           `id` int(11) NOT NULL,
                           `type` enum('recommandation','nouveauté','partage','information') DEFAULT NULL,
                           `content` enum('Album','Playlist','Track','User','Podcast','Artist') DEFAULT NULL,
                           `description` text,
                           `period` date DEFAULT NULL,
                           `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`id`, `type`, `content`, `description`, `period`, `user_id`) VALUES
(1, 'recommandation', 'Album', 'Recommandation Album 1', '2020-02-27', 1),
(2, 'nouveauté', 'Track', 'Nouveauté Track 1', '2020-02-29', 2),
(3, 'partage', 'Playlist', 'Partage Playlist ', '2020-02-27', 3),
(4, 'information', 'Artist', 'Information Artist ', '2020-03-17', 1),
(5, 'nouveauté', 'Podcast', 'Nouveauté Podcast', '2020-02-25', 1);

-- --------------------------------------------------------

--
-- Table structure for table `message_album`
--

CREATE TABLE `message_album` (
                                 `message_id` int(11) NOT NULL,
                                 `album_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `message_album`
--

INSERT INTO `message_album` (`message_id`, `album_id`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `message_artist`
--

CREATE TABLE `message_artist` (
                                  `message_id` int(11) NOT NULL,
                                  `artist_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `message_artist`
--

INSERT INTO `message_artist` (`message_id`, `artist_id`) VALUES
(4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `message_playlist`
--

CREATE TABLE `message_playlist` (
                                    `message_id` int(11) NOT NULL,
                                    `playlist_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `message_playlist`
--

INSERT INTO `message_playlist` (`message_id`, `playlist_id`) VALUES
(3, 3);

-- --------------------------------------------------------

--
-- Table structure for table `message_podcast`
--

CREATE TABLE `message_podcast` (
                                   `message_id` int(11) NOT NULL,
                                   `podcast_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `message_podcast`
--

INSERT INTO `message_podcast` (`message_id`, `podcast_id`) VALUES
(5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `message_track`
--

CREATE TABLE `message_track` (
                                 `message_id` int(11) NOT NULL,
                                 `track_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `message_track`
--

INSERT INTO `message_track` (`message_id`, `track_id`) VALUES
(2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
                                `id` int(11) NOT NULL,
                                `user_id` int(11) NOT NULL,
                                `message_id` int(11) NOT NULL,
                                `status` int(1) DEFAULT NULL,
                                `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `notification`
--

INSERT INTO `notification` (`id`, `user_id`, `message_id`, `status`) VALUES
(1, 1, 1, 1),
(2, 2, 4, 0),
(3, 2, 3, 1),
(4, 3, 5, 0),
(5, 2, 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `playlist`
--

CREATE TABLE `playlist` (
                            `id` int(11) NOT NULL,
                            `name` varchar(45) DEFAULT NULL,
                            `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `playlist`
--

INSERT INTO `playlist` (`id`, `name`, `user_id`) VALUES
(1, 'Playlist 1', 1),
(2, 'Playlist 2', 2),
(3, 'Playlist 3', 3);

-- --------------------------------------------------------

--
-- Table structure for table `playlist_track`
--

CREATE TABLE `playlist_track` (
                                  `playlist_id` int(11) NOT NULL,
                                  `track_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `playlist_track`
--

INSERT INTO `playlist_track` (`playlist_id`, `track_id`) VALUES
(1, 1),
(2, 2),
(3, 3),
(1, 4),
(1, 5);

-- --------------------------------------------------------

--
-- Table structure for table `podcast`
--

CREATE TABLE `podcast` (
                           `id` int(11) NOT NULL,
                           `title` varchar(45) DEFAULT NULL,
                           `year` int(11) DEFAULT NULL,
                           `artist_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `podcast`
--

INSERT INTO `podcast` (`id`, `title`, `year`, `artist_id`) VALUES
(1, 'Podcast 1', 2017, 1),
(2, 'Podcast 2', 2018, 2),
(3, 'Podcast', 2019, 3);

-- --------------------------------------------------------

--
-- Table structure for table `track`
--

CREATE TABLE `track` (
                         `id` int(11) NOT NULL,
                         `title` varchar(100) DEFAULT NULL,
                         `description` varchar(45) DEFAULT NULL,
                         `album_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `track`
--

INSERT INTO `track` (`id`, `title`, `description`, `album_id`) VALUES
(1, 'Track 1', 'Description Album Track 1 Album 1', 1),
(2, 'Track 1', 'Description Album Track 1 Album 2', 2),
(3, 'Track 1', 'Description Album Track 1 Album 3', 3),
(4, 'Track 1', 'Description Album Track 1 Album 4', 4),
(5, 'Track 2', 'Description Album Track 2 Album 1', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
                        `id` int(11) NOT NULL,
                        `name` varchar(45) DEFAULT NULL,
                        `email` varchar(100) DEFAULT NULL,
                        `password` varchar(100) DEFAULT NULL,
                        `type` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `password`, `type`) VALUES
(1, 'Dezzer', 'deezer@deezer.cm', '202cb962ac59075b964b07152d234b70', 'administrator'),
(2, 'user 1', 'user1@deezer.com', '202cb962ac59075b964b07152d234b70', 'user'),
(3, 'user 2', 'user2@deezer.com', '202cb962ac59075b964b07152d234b70', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `album`
--
ALTER TABLE `album`
    ADD PRIMARY KEY (`id`),
    ADD KEY `fk_album_artist1_idx` (`artist_id`);

--
-- Indexes for table `artist`
--
ALTER TABLE `artist`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
    ADD PRIMARY KEY (`id`),
    ADD KEY `fk_message_user1_idx` (`user_id`);

--
-- Indexes for table `message_album`
--
ALTER TABLE `message_album`
    ADD PRIMARY KEY (`message_id`,`album_id`),
    ADD KEY `fk_message_has_album_album1_idx` (`album_id`),
    ADD KEY `fk_message_has_album_message1_idx` (`message_id`);

--
-- Indexes for table `message_artist`
--
ALTER TABLE `message_artist`
    ADD PRIMARY KEY (`message_id`,`artist_id`),
    ADD KEY `fk_message_has_artist_artist1_idx` (`artist_id`),
    ADD KEY `fk_message_has_artist_message1_idx` (`message_id`);

--
-- Indexes for table `message_playlist`
--
ALTER TABLE `message_playlist`
    ADD PRIMARY KEY (`message_id`,`playlist_id`),
    ADD KEY `fk_message_playlist_playlist_idx` (`playlist_id`) USING BTREE,
    ADD KEY `fk_message_playlist_message_idx` (`message_id`) USING BTREE;

--
-- Indexes for table `message_podcast`
--
ALTER TABLE `message_podcast`
    ADD PRIMARY KEY (`message_id`,`podcast_id`),
    ADD KEY `fk_message_has_podcast_podcast1_idx` (`podcast_id`),
    ADD KEY `fk_message_has_podcast_message1_idx` (`message_id`);

--
-- Indexes for table `message_track`
--
ALTER TABLE `message_track`
    ADD PRIMARY KEY (`message_id`,`track_id`),
    ADD KEY `fk_message_has_track_track1_idx` (`track_id`),
    ADD KEY `fk_message_has_track_message1_idx` (`message_id`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
    ADD PRIMARY KEY (`id`),
    ADD KEY `fk_user_has_message_message1_idx` (`message_id`),
    ADD KEY `fk_user_has_message_user1_idx` (`user_id`);

--
-- Indexes for table `playlist`
--
ALTER TABLE `playlist`
    ADD PRIMARY KEY (`id`),
    ADD KEY `fk_playlist_user1_idx` (`user_id`);

--
-- Indexes for table `playlist_track`
--
ALTER TABLE `playlist_track`
    ADD PRIMARY KEY (`playlist_id`,`track_id`),
    ADD KEY `fk_playlist_has_track_track1_idx` (`track_id`),
    ADD KEY `fk_playlist_has_track_playlist1_idx` (`playlist_id`);

--
-- Indexes for table `podcast`
--
ALTER TABLE `podcast`
    ADD PRIMARY KEY (`id`),
    ADD KEY `fk_podcast_artist_idx` (`artist_id`);

--
-- Indexes for table `track`
--
ALTER TABLE `track`
    ADD PRIMARY KEY (`id`),
    ADD KEY `fk_track_album1_idx` (`album_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
    ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `album`
--
ALTER TABLE `album`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `artist`
--
ALTER TABLE `artist`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `playlist`
--
ALTER TABLE `playlist`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `podcast`
--
ALTER TABLE `podcast`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `track`
--
ALTER TABLE `track`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `album`
--
ALTER TABLE `album`
    ADD CONSTRAINT `fk_album_artist1` FOREIGN KEY (`artist_id`) REFERENCES `artist` (`id`);

--
-- Constraints for table `message`
--
ALTER TABLE `message`
    ADD CONSTRAINT `fk_message_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `message_album`
--
ALTER TABLE `message_album`
    ADD CONSTRAINT `fk_message_album_album` FOREIGN KEY (`album_id`) REFERENCES `album` (`id`),
    ADD CONSTRAINT `fk_message_album_message` FOREIGN KEY (`message_id`) REFERENCES `message` (`id`);

--
-- Constraints for table `message_artist`
--
ALTER TABLE `message_artist`
    ADD CONSTRAINT `fk_message_artist_artist` FOREIGN KEY (`artist_id`) REFERENCES `artist` (`id`),
    ADD CONSTRAINT `fk_message_artist_message` FOREIGN KEY (`message_id`) REFERENCES `message` (`id`);

--
-- Constraints for table `message_playlist`
--
ALTER TABLE `message_playlist`
    ADD CONSTRAINT `fk_message_playlist_message` FOREIGN KEY (`message_id`) REFERENCES `message` (`id`),
    ADD CONSTRAINT `fk_message_playlist_playlist` FOREIGN KEY (`playlist_id`) REFERENCES `playlist` (`id`);

--
-- Constraints for table `message_podcast`
--
ALTER TABLE `message_podcast`
    ADD CONSTRAINT `fk_message_podcast_message` FOREIGN KEY (`message_id`) REFERENCES `message` (`id`),
    ADD CONSTRAINT `fk_message_podcast_podcast` FOREIGN KEY (`podcast_id`) REFERENCES `podcast` (`id`);

--
-- Constraints for table `message_track`
--
ALTER TABLE `message_track`
    ADD CONSTRAINT `fk_message_track_message` FOREIGN KEY (`message_id`) REFERENCES `message` (`id`),
    ADD CONSTRAINT `fk_message_track_track` FOREIGN KEY (`track_id`) REFERENCES `track` (`id`);

--
-- Constraints for table `notification`
--
ALTER TABLE `notification`
    ADD CONSTRAINT `fk_user_has_message_message1` FOREIGN KEY (`message_id`) REFERENCES `message` (`id`),
    ADD CONSTRAINT `fk_user_has_message_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `playlist`
--
ALTER TABLE `playlist`
    ADD CONSTRAINT `fk_playlist_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `playlist_track`
--
ALTER TABLE `playlist_track`
    ADD CONSTRAINT `fk_playlist_has_track_playlist1` FOREIGN KEY (`playlist_id`) REFERENCES `playlist` (`id`),
    ADD CONSTRAINT `fk_playlist_has_track_track1` FOREIGN KEY (`track_id`) REFERENCES `track` (`id`);

--
-- Constraints for table `podcast`
--
ALTER TABLE `podcast`
    ADD CONSTRAINT `fk_podcast_artist` FOREIGN KEY (`artist_id`) REFERENCES `artist` (`id`);

--
-- Constraints for table `track`
--
ALTER TABLE `track`
    ADD CONSTRAINT `fk_track_album1` FOREIGN KEY (`album_id`) REFERENCES `album` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
