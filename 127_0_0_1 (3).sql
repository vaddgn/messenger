-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Фев 06 2025 г., 14:00
-- Версия сервера: 10.4.32-MariaDB
-- Версия PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `messanger`
--
CREATE DATABASE IF NOT EXISTS `messanger` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `messanger`;

-- --------------------------------------------------------

--
-- Структура таблицы `conversations`
--

CREATE TABLE `conversations` (
  `id` int(11) NOT NULL,
  `participant_one_id` varchar(50) NOT NULL,
  `participant_two_id` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `conversation_id` int(11) NOT NULL,
  `sender_id` varchar(50) NOT NULL,
  `content` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `receiver_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(24) DEFAULT NULL,
  `profile_photo` varchar(255) NOT NULL DEFAULT '/img/avatar404.png',
  `user_id` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `user_password` varchar(255) DEFAULT NULL,
  `user_token` varchar(32) NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `username`, `profile_photo`, `user_id`, `email`, `user_password`, `user_token`, `is_admin`) VALUES
(37, 'riki1', '/img/0y9OaZB1e_i83qZVk9cKZPtwitKuK4DM.jpg', 'riki1', 'riki1@gmail.com', '$2y$13$OGtgQkurgBVlBqjJxH0FvO3gLcNGCyK/BgIUiwydAx2QLPRKjT8By', 'IOFlMF_wJ3OnxhCzJhV2IZohoJ7Qlb2f', 0),
(38, 'Alex', '/img/avatar404.png', 'viper', 'viper@gmail.com', '$2y$13$QYw2l78IgbwhpiMwUO.1WeRiPWow0uV9klWgid9nodVJBL8SGmzlO', 'IDBxgJIlYI-4ox2ceozr0P3xDf15gFSm', 1),
(39, 'Keksad', '/img/avatar404.png', 'keksad', 'keksad@gmail.com', '$2y$13$6xleqYBHSctLjnq2ZVGnNe2drfLjgRZ42UpS8.vBN9kRKIxJiRcrS', '-BqpJ6ED7xyNI4a3xXicYVGBVbLmTGKX', 0),
(40, 'flexit12312', '/img/avatar404.png', 'flexit', 'flexit@gmail.com', '$2y$13$SNtm0mzh9dMHX97s8YSZEuLcw2HiF6aSW0ABH1Ty/MjKe4ODNTFG2', 'kzycu8s5DRCOviGHYfo8WEKa7gYc2O3N', 0),
(41, 'Вадим', '/img/avatar404.png', 'asdsad', 'asdas@gmail.com', '$2y$13$LViI0G2X8OIsghxrT9tzru2QX7d.7S7HvAfkCMCKcaA1e/MEXAlxG', 'J-uxXFwaV4vL6LNJFjbPZ45Cs5Vgh-mz', 0),
(42, 'Pavel Novikov', '/img/bn5NEiDKZDFPDJcg1G-Nhi2COzTVrMyZ.jpg', 'pavel231', 'pavelnovikov@gmail.com', '$2y$13$T8u3eGtakZ1tHNxUHzSHJedDY9.4nfTUIXIWLDJToK.mrITNF7H3.', 'iiVtDCTb88FHWp2tE6soezXWoIgyMeVR', 0),
(43, 'Igor Ivanov', '/img/jfr23kXZVSH214gen5WZwTTBtfoh8HLY.jpg', 'ivanov777', 'ivanov777@gmail.com', '$2y$13$QFHrqx4S3kRFVn.8w6LmtOp4xfBg3KioyfErmKnakYxEIsBAeK0Zy', 'fkcTpsjUNIBK0kqIynlAQ4rFAZmqJYGD', 0);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `conversations`
--
ALTER TABLE `conversations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_participants` (`participant_one_id`,`participant_two_id`);

--
-- Индексы таблицы `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_messages_conversations` (`conversation_id`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `conversations`
--
ALTER TABLE `conversations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=203;

--
-- AUTO_INCREMENT для таблицы `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1434;

--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `fk_messages_conversations` FOREIGN KEY (`conversation_id`) REFERENCES `conversations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`conversation_id`) REFERENCES `conversations` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
