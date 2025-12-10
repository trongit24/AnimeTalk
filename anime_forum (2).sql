-- Active: 1758659677145@@127.0.0.1@3306@anime_forum_v1_1
-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th12 09, 2025 lúc 10:39 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12
USE anime_forum_V1_1;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `anime_forum`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `comments`
--

CREATE TABLE `comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` varchar(20) NOT NULL,
  `post_id` bigint(20) UNSIGNED DEFAULT NULL,
  `commentable_id` bigint(20) UNSIGNED DEFAULT NULL,
  `commentable_type` varchar(255) DEFAULT NULL,
  `content` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `likes` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `comments`
--

INSERT INTO `comments` (`id`, `user_id`, `post_id`, `commentable_id`, `commentable_type`, `content`, `image`, `likes`, `created_at`, `updated_at`) VALUES
(6, 'U7398765524', 6, 6, 'App\\Models\\Post', 'Hẹ', NULL, 0, '2025-11-18 04:41:06', '2025-11-18 04:41:06'),
(7, 'U3564188634', 6, 6, 'App\\Models\\Post', 'Iu', NULL, 0, '2025-11-18 04:59:17', '2025-11-18 04:59:17'),
(23, 'U3203506368', 6, 6, 'App\\Models\\Post', 'cacc', NULL, 0, '2025-12-01 09:54:24', '2025-12-01 09:54:24'),
(27, 'U3203506368', 6, 6, 'App\\Models\\Post', 'https://media2.giphy.com/media/GGcRBaRwdtmhNvLchh/100.gif?cid=e2143c21i1ec1mllef69gn9bkhcla07tmk1ywfmd9mf12imp&ep=v1_gifs_search&rid=100.gif&ct=g', NULL, 0, '2025-12-01 10:19:52', '2025-12-01 10:19:52'),
(28, 'U3203506368', 6, 6, 'App\\Models\\Post', 'cac', 'comments/8gZeXHpC8YQczqnTBfUQ2fgAIAd3bGssL1nKmPnY.png', 0, '2025-12-01 10:24:23', '2025-12-01 10:24:23'),
(29, 'U3203506368', NULL, 1, 'App\\Models\\CommunityPost', 'cac', NULL, 0, '2025-12-02 06:29:48', '2025-12-02 06:29:48'),
(31, 'U3203506368', 6, NULL, NULL, 'https://media4.giphy.com/media/8JCIWBz8oRRLZmZhNn/100.gif?cid=e2143c21qql6v3l3myojkh60isyvukyp8z9z43cem7ea5e4b&ep=v1_gifs_search&rid=100.gif&ct=g', NULL, 0, '2025-12-09 01:56:47', '2025-12-09 01:56:47');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `communities`
--

CREATE TABLE `communities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` varchar(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `banner` varchar(255) DEFAULT NULL,
  `category` varchar(255) NOT NULL DEFAULT 'General',
  `members_count` int(11) NOT NULL DEFAULT 1,
  `is_private` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `communities`
--

INSERT INTO `communities` (`id`, `user_id`, `name`, `slug`, `description`, `icon`, `banner`, `category`, `members_count`, `is_private`, `created_at`, `updated_at`) VALUES
(1, 'U7398765524', 'Girl Anime', 'girl-anime', 'Join with me', 'communities/icons/VvtYAva3jtdueNiEULdK4TfD7mT9E2BJcR0ODSY3.png', 'communities/banners/mddcD95Vgvq4U6Jm4xbW7DasU3SBWEkR8vBcfPs1.jpg', 'Anime', 4, 1, '2025-11-17 00:18:10', '2025-11-19 04:47:12');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `community_activities`
--

CREATE TABLE `community_activities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `community_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `post_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `community_activities`
--

INSERT INTO `community_activities` (`id`, `community_id`, `user_id`, `type`, `description`, `post_id`, `created_at`, `updated_at`) VALUES
(1, 1, 'U3203506368', 'joined', 'Hirra joined the community', NULL, '2025-11-17 00:46:41', '2025-11-17 00:46:41'),
(2, 1, 'U3564188634', 'joined', 'Nguyen joined the community', NULL, '2025-11-18 05:04:15', '2025-11-18 05:04:15');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `community_members`
--

CREATE TABLE `community_members` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `community_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` varchar(20) NOT NULL,
  `role` enum('owner','moderator','member') NOT NULL DEFAULT 'member',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `community_members`
--

INSERT INTO `community_members` (`id`, `community_id`, `user_id`, `role`, `created_at`, `updated_at`) VALUES
(1, 1, 'U7398765524', 'owner', '2025-11-17 00:18:10', '2025-11-17 00:18:10'),
(2, 1, 'U3203506368', 'member', '2025-11-17 00:46:41', '2025-11-17 00:46:41'),
(3, 1, 'U3564188634', 'member', '2025-11-18 05:04:15', '2025-11-18 05:04:15');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `community_memories`
--

CREATE TABLE `community_memories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `community_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` varchar(20) NOT NULL,
  `image` varchar(255) NOT NULL,
  `caption` text DEFAULT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `approved_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `community_memories`
--

INSERT INTO `community_memories` (`id`, `community_id`, `user_id`, `image`, `caption`, `status`, `approved_at`, `created_at`, `updated_at`) VALUES
(6, 1, 'U3203506368', 'memories/9EPLhGNVMZQ8GxZHsfy7rJMTolFys50sQxiAKWQA.jpg', 'dd', 'approved', '2025-12-03 07:29:16', '2025-12-03 07:27:19', '2025-12-03 07:29:16'),
(7, 1, 'U3564188634', 'memories/7XjDYyJSW8ewdYmVuoQ8vpxmhNGqy3i7TISH5qJ6.jpg', 'fffff', 'approved', '2025-12-03 07:32:17', '2025-12-03 07:31:46', '2025-12-03 07:32:17'),
(8, 1, 'U3203506368', 'memories/XXsyQ4Xz0fbQfM1urZ6HR0qPEVX04ZROrVnS0vys.jpg', 'hiihi', 'approved', '2025-12-09 01:58:24', '2025-12-09 01:57:55', '2025-12-09 01:58:24');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `community_messages`
--

CREATE TABLE `community_messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `community_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `is_pinned` tinyint(1) NOT NULL DEFAULT 0,
  `pinned_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `community_messages`
--

INSERT INTO `community_messages` (`id`, `community_id`, `user_id`, `message`, `image`, `is_pinned`, `pinned_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'U3203506368', 'hi', NULL, 0, NULL, '2025-12-02 05:18:02', '2025-12-02 05:18:02'),
(2, 1, 'U3203506368', 'hi', 'community-chat/DBZcE0Mk5k5yWRGlkmSGVrb7CcSJclopnhqw9UPJ.png', 0, NULL, '2025-12-02 05:21:39', '2025-12-02 05:21:39'),
(3, 1, 'U3203506368', 'hi', 'community-chat/fl1VMKr3phlrSxR19lzqGeob1RsSUSj4felsNwKH.png', 0, NULL, '2025-12-02 05:21:39', '2025-12-02 05:21:39'),
(4, 1, 'U3203506368', 'hi', NULL, 0, NULL, '2025-12-02 05:21:40', '2025-12-02 05:21:40'),
(5, 1, 'U3203506368', 'hi', 'community-chat/PYM7rDUh0GzQnoFov6YNRhdmJYSzJkvtwh1Ru9zw.png', 0, NULL, '2025-12-02 05:21:40', '2025-12-02 05:21:40');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `community_posts`
--

CREATE TABLE `community_posts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `community_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `video` varchar(255) DEFAULT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `reviewed_by` varchar(255) DEFAULT NULL,
  `reviewed_at` timestamp NULL DEFAULT NULL,
  `reject_reason` text DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `approved_by` varchar(255) DEFAULT NULL,
  `rejection_reason` text DEFAULT NULL,
  `likes_count` int(11) NOT NULL DEFAULT 0,
  `comments_count` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `community_posts`
--

INSERT INTO `community_posts` (`id`, `community_id`, `user_id`, `content`, `image`, `video`, `status`, `reviewed_by`, `reviewed_at`, `reject_reason`, `approved_at`, `approved_by`, `rejection_reason`, `likes_count`, `comments_count`, `created_at`, `updated_at`) VALUES
(1, 1, 'U3203506368', 'Hihe', 'community-posts/wi05Kl904SjlH4HLLCwXDpXk4XSa6IVJBqaGdIXS.png', NULL, 'approved', 'U7398765524', '2025-12-02 05:35:24', NULL, NULL, NULL, NULL, 0, 0, '2025-12-02 05:22:53', '2025-12-02 05:35:24');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `events`
--

CREATE TABLE `events` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `cover_image` varchar(255) DEFAULT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime DEFAULT NULL,
  `privacy` enum('public','private','friends') NOT NULL DEFAULT 'public',
  `participants_count` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `events`
--

INSERT INTO `events` (`id`, `user_id`, `title`, `slug`, `description`, `location`, `cover_image`, `start_time`, `end_time`, `privacy`, `participants_count`, `created_at`, `updated_at`) VALUES
(1, 'U7398765524', 'The Cosplay Anime from Đa Nang', 'the-cosplay-anime-from-da-nang-6937db913441a', NULL, 'Tokyo', 'events/covers/IMrFvpmLU38hqqkuXJRninmOSBBWvygVeZdZll9r.jpg', '2025-11-18 20:45:00', '2025-11-18 20:47:00', 'public', 2, '2025-11-18 06:47:34', '2025-12-09 01:19:29');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `event_notifications`
--

CREATE TABLE `event_notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `event_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'event_reminder',
  `message` text NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `event_participants`
--

CREATE TABLE `event_participants` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `event_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `status` enum('going','interested','invited','declined') NOT NULL DEFAULT 'going',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `event_participants`
--

INSERT INTO `event_participants` (`id`, `event_id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'U7398765524', 'going', '2025-11-18 06:47:34', '2025-11-18 06:47:34'),
(4, 1, 'U3203506368', 'going', '2025-11-28 01:58:12', '2025-11-28 01:58:12');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `friendships`
--

CREATE TABLE `friendships` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `friend_id` varchar(255) NOT NULL,
  `status` enum('pending','accepted','rejected') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `friendships`
--

INSERT INTO `friendships` (`id`, `user_id`, `friend_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 'U3203506368', 'U7398765524', 'accepted', '2025-11-17 03:20:43', '2025-11-17 03:21:15'),
(5, 'U3203506368', 'U3564188634', 'accepted', '2025-12-02 03:09:42', '2025-12-02 03:30:07'),
(6, 'U7398765524', 'U3564188634', 'accepted', '2025-12-09 01:59:22', '2025-12-09 02:00:01');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `memory_reactions`
--

CREATE TABLE `memory_reactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `memory_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` varchar(20) NOT NULL,
  `reaction` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `messages`
--

CREATE TABLE `messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sender_id` varchar(255) NOT NULL,
  `receiver_id` varchar(255) NOT NULL,
  `message` text DEFAULT NULL,
  `message_type` varchar(255) NOT NULL DEFAULT 'text',
  `image` varchar(255) DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `messages`
--

INSERT INTO `messages` (`id`, `sender_id`, `receiver_id`, `message`, `message_type`, `image`, `is_read`, `created_at`, `updated_at`) VALUES
(1, 'U3203506368', 'U7398765524', 'Lọ Vương', 'text', NULL, 1, '2025-11-17 07:15:50', '2025-11-17 21:22:51'),
(2, 'U3203506368', 'U7398765524', 'anh iu em', 'text', NULL, 1, '2025-11-17 07:20:13', '2025-11-17 21:22:51'),
(3, 'U7398765524', 'U3203506368', 'Dth dọ', 'text', NULL, 1, '2025-11-17 21:22:58', '2025-11-17 21:23:01'),
(4, 'U7398765524', 'U3203506368', '🥰', 'text', NULL, 1, '2025-11-17 21:23:10', '2025-11-17 21:23:13'),
(5, 'U7398765524', 'U3203506368', 'Vãi ò', 'text', NULL, 1, '2025-11-17 21:24:49', '2025-11-17 21:24:52'),
(6, 'U7398765524', 'U3203506368', 'Vãi ò', 'text', NULL, 1, '2025-11-17 21:24:49', '2025-11-17 21:24:52'),
(7, 'U7398765524', 'U3203506368', 'Vãi ò', 'text', NULL, 1, '2025-11-17 21:24:49', '2025-11-17 21:24:52'),
(8, 'U7398765524', 'U3203506368', 'Gây lọ', 'text', NULL, 1, '2025-11-18 04:41:45', '2025-11-18 04:41:45'),
(9, 'U3203506368', 'U7398765524', NULL, 'image', 'messages/az48qQ52OGEZd17LpqTZ7FdTX0aZwjZ3Xr0MDdOk.jpg', 1, '2025-11-18 04:50:41', '2025-11-18 04:50:43'),
(10, 'U3203506368', 'U7398765524', NULL, 'image', 'messages/HhHvmJtVPkdPv7Gh7IU3kzTauj01aaYbf3aEtlrd.jpg', 1, '2025-11-18 04:51:16', '2025-11-18 04:51:16'),
(11, 'U7398765524', 'U3203506368', '😀', 'text', NULL, 1, '2025-11-18 04:51:25', '2025-11-18 04:51:26'),
(12, 'U7398765524', 'U3203506368', NULL, 'image', 'messages/rfA0hWr4FFpO3JiGoIMfzqHmCFYofZmJbKPpEyS5.jpg', 1, '2025-11-18 04:55:51', '2025-11-18 04:55:52'),
(13, 'U3564188634', 'U3203506368', 'Hẹ hẹ hẹ', 'text', NULL, 1, '2025-11-18 05:03:16', '2025-11-18 05:03:16'),
(14, 'U3203506368', 'U3564188634', '😀', 'text', NULL, 1, '2025-11-18 05:03:22', '2025-11-18 05:03:23'),
(27, 'U7398765524', 'U3203506368', 'https://media3.giphy.com/media/Hs1ZdBBpaHO9y/giphy.gif?cid=e2143c21qql6v3l3myojkh60isyvukyp8z9z43cem7ea5e4b&ep=v1_gifs_search&rid=giphy.gif&ct=g', 'gif', NULL, 1, '2025-12-09 01:59:39', '2025-12-09 02:00:13');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2024_01_01_000003_create_tags_table', 1),
(5, '2024_01_01_000004_create_forums_table', 1),
(6, '2024_01_01_000005_create_posts_table', 1),
(7, '2024_01_01_000006_create_events_table', 1),
(8, '2024_01_01_000007_create_comments_table', 1),
(9, '2024_01_01_000008_create_post_tag_table', 1),
(10, '2024_01_01_000009_create_forum_tag_table', 1),
(11, '2024_01_01_000010_add_avatar_bio_to_users_table', 1),
(12, '2025_11_16_163427_create_post_likes_table', 1),
(13, '2025_11_16_172926_create_communities_table', 1),
(14, '2025_11_16_172937_create_community_members_table', 1),
(15, '2025_11_16_175116_add_profile_photo_to_users_table', 1),
(16, '2025_11_16_180206_make_forum_id_nullable_in_posts_table', 1),
(17, '2025_11_16_180641_add_video_to_posts_table', 1),
(18, '2025_11_16_185814_add_image_to_comments_table', 1),
(19, '2025_11_16_190700_drop_events_table', 1),
(20, '2025_11_16_192527_add_cover_photo_to_users_table', 1),
(21, '2025_11_16_193018_drop_forums_table', 1),
(22, '2025_11_16_195748_change_users_primary_key_to_uid', 1),
(23, '2025_11_16_201435_add_category_to_posts_table', 2),
(24, '2025_11_16_202000_drop_unused_tables', 3),
(25, '2025_11_17_072438_create_community_activities_table', 3),
(26, '2025_11_17_101126_create_friendships_table', 4),
(27, '2025_11_17_101135_create_messages_table', 4),
(28, '2025_11_17_135210_remove_avatar_column_from_users_table', 5),
(29, '2025_11_17_142205_add_image_and_type_to_messages_table', 6),
(30, '2025_11_18_095653_add_role_to_users_table', 7),
(31, '2025_11_18_112821_add_community_id_to_posts_table', 8),
(32, '2025_11_18_114938_make_message_nullable_in_messages_table', 9),
(33, '2025_11_18_124648_create_events_table', 10),
(34, '2025_11_18_124657_create_event_participants_table', 10),
(35, '2025_11_18_130138_create_event_notifications_table', 11),
(36, '2025_11_19_095900_add_background_to_posts_table', 12),
(37, '2025_12_02_103604_create_notifications_table', 13),
(38, '2025_12_02_110530_create_community_posts_table', 14),
(39, '2025_12_02_110648_create_community_messages_table', 14),
(40, '2025_12_02_112027_create_community_posts_table', 1),
(41, '2025_12_02_112033_create_community_messages_table', 1),
(42, '2025_12_02_122738_add_reviewed_by_to_community_posts_table', 15),
(43, '2025_12_02_123306_add_reviewed_by_to_community_posts_table', 15),
(44, '2025_12_02_130353_add_polymorphic_to_comments_table', 16),
(45, '2025_12_02_130707_add_polymorphic_to_post_likes_table', 17),
(46, '2025_12_02_132652_make_post_id_nullable_in_post_likes_table', 18),
(47, '2025_12_02_132843_make_post_id_nullable_in_comments_table', 19),
(48, '2025_12_02_135745_create_community_memories_table', 20),
(49, '2025_12_02_135827_create_memory_reactions_table', 20),
(50, '2025_12_03_135732_add_status_to_community_memories_table', 21),
(51, '2025_12_03_144052_create_post_reports_table', 22),
(52, '2025_12_03_144122_add_hidden_fields_to_posts_table', 22),
(53, '2025_12_09_081906_add_slug_to_events_table', 23);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` varchar(255) DEFAULT NULL,
  `type` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `data` text DEFAULT NULL,
  `action_url` varchar(255) DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `type`, `title`, `message`, `data`, `action_url`, `is_read`, `read_at`, `created_at`, `updated_at`) VALUES
(1, NULL, 'admin_announcement', 'HỆ THỐNG SẼ CHUYỂN SANG HOẠT HÌNH', 'Vào ngày mai, hệ thống sẽ cùng đi xem hoạt hình', NULL, 'https://www.imdb.com/title/tt26443597/', 1, '2025-12-02 03:50:09', '2025-12-02 03:49:40', '2025-12-02 03:50:09'),
(2, 'U7398765524', 'community_post_pending', 'Bài viết mới cần duyệt', 'Hirra đã đăng bài viết mới trong cộng đồng \"Girl Anime\"', '{\"community_id\":1,\"post_id\":1}', 'http://127.0.0.1:8000/communities/girl-anime/posts/pending', 1, '2025-12-02 05:23:30', '2025-12-02 05:22:53', '2025-12-02 05:23:30'),
(3, 'U3203506368', 'community_post_approved', 'Bài viết đã được duyệt', 'Bài viết của bạn trong cộng đồng \"Girl Anime\" đã được duyệt', '{\"community_id\":1,\"post_id\":1}', 'http://127.0.0.1:8000/communities/girl-anime', 1, '2025-12-02 05:37:46', '2025-12-02 05:35:24', '2025-12-02 05:37:46'),
(4, NULL, 'memory_pending', 'Kỷ niệm mới chờ duyệt', 'Hirra đã tạo kỷ niệm mới trong cộng đồng Girl Anime', '\"{\\\"memory_id\\\":3,\\\"community_slug\\\":\\\"girl-anime\\\",\\\"user_name\\\":\\\"Hirra\\\",\\\"user_avatar\\\":null}\"', 'http://127.0.0.1:8000/communities/girl-anime', 1, '2025-12-03 07:07:41', '2025-12-03 07:07:14', '2025-12-03 07:07:41'),
(5, NULL, 'memory_pending', 'Kỷ niệm mới chờ duyệt', 'Hirra đã tạo kỷ niệm mới trong cộng đồng Girl Anime', '\"{\\\"memory_id\\\":4,\\\"community_slug\\\":\\\"girl-anime\\\",\\\"user_name\\\":\\\"Hirra\\\",\\\"user_avatar\\\":null}\"', 'http://127.0.0.1:8000/communities/girl-anime', 1, '2025-12-03 07:17:19', '2025-12-03 07:16:50', '2025-12-03 07:17:19'),
(6, 'U3203506368', 'memory_rejected', 'Kỷ niệm bị từ chối', 'Kỷ niệm của bạn trong cộng đồng Girl Anime đã bị từ chối.', '\"{\\\"community_slug\\\":\\\"girl-anime\\\",\\\"community_name\\\":\\\"Girl Anime\\\"}\"', 'http://127.0.0.1:8000/communities/girl-anime', 1, '2025-12-03 07:26:21', '2025-12-03 07:22:15', '2025-12-03 07:26:21'),
(7, 'U3203506368', 'memory_rejected', 'Kỷ niệm bị từ chối', 'Kỷ niệm của bạn trong cộng đồng Girl Anime đã bị từ chối.', '\"{\\\"community_slug\\\":\\\"girl-anime\\\",\\\"community_name\\\":\\\"Girl Anime\\\"}\"', 'http://127.0.0.1:8000/communities/girl-anime', 1, '2025-12-03 07:26:21', '2025-12-03 07:22:25', '2025-12-03 07:26:21'),
(8, 'U3203506368', 'memory_rejected', 'Kỷ niệm bị từ chối', 'Kỷ niệm của bạn trong cộng đồng Girl Anime đã bị từ chối.', '\"{\\\"community_slug\\\":\\\"girl-anime\\\",\\\"community_name\\\":\\\"Girl Anime\\\"}\"', 'http://127.0.0.1:8000/communities/girl-anime', 1, '2025-12-03 07:26:21', '2025-12-03 07:24:07', '2025-12-03 07:26:21'),
(9, 'U7398765524', 'memory_pending', 'Kỷ niệm mới chờ duyệt', 'Hirra đã tạo kỷ niệm mới trong cộng đồng Girl Anime', '\"{\\\"memory_id\\\":5,\\\"community_slug\\\":\\\"girl-anime\\\",\\\"user_name\\\":\\\"Hirra\\\",\\\"user_avatar\\\":null}\"', 'http://127.0.0.1:8000/communities/girl-anime', 1, '2025-12-03 07:26:34', '2025-12-03 07:26:13', '2025-12-03 07:26:34'),
(10, 'U7398765524', 'memory_pending', 'Kỷ niệm mới chờ duyệt', 'Hirra đã tạo kỷ niệm mới trong cộng đồng Girl Anime', '\"{\\\"memory_id\\\":6,\\\"community_slug\\\":\\\"girl-anime\\\",\\\"user_name\\\":\\\"Hirra\\\",\\\"user_avatar\\\":null}\"', 'http://127.0.0.1:8000/communities/girl-anime', 1, '2025-12-03 07:27:29', '2025-12-03 07:27:19', '2025-12-03 07:27:29'),
(11, 'U3203506368', 'memory_approved', 'Kỷ niệm đã được duyệt', 'Kỷ niệm của bạn trong cộng đồng Girl Anime đã được duyệt!', '\"{\\\"memory_id\\\":6,\\\"community_slug\\\":\\\"girl-anime\\\",\\\"community_name\\\":\\\"Girl Anime\\\"}\"', 'http://127.0.0.1:8000/communities/girl-anime', 1, '2025-12-03 07:31:19', '2025-12-03 07:29:16', '2025-12-03 07:31:19'),
(12, 'U7398765524', 'memory_pending', 'Kỷ niệm mới chờ duyệt', 'Nguyen đã tạo kỷ niệm mới trong cộng đồng Girl Anime', '\"{\\\"memory_id\\\":7,\\\"community_slug\\\":\\\"girl-anime\\\",\\\"user_name\\\":\\\"Nguyen\\\",\\\"user_avatar\\\":null}\"', 'http://127.0.0.1:8000/communities/girl-anime', 1, '2025-12-03 07:32:11', '2025-12-03 07:31:46', '2025-12-03 07:32:11'),
(13, 'U3564188634', 'memory_approved', 'Kỷ niệm đã được duyệt', 'Kỷ niệm của bạn trong cộng đồng Girl Anime đã được duyệt!', '\"{\\\"memory_id\\\":7,\\\"community_slug\\\":\\\"girl-anime\\\",\\\"community_name\\\":\\\"Girl Anime\\\"}\"', 'http://127.0.0.1:8000/communities/girl-anime', 1, '2025-12-03 08:16:31', '2025-12-03 07:32:17', '2025-12-03 08:16:31'),
(17, 'U7398765524', 'memory_pending', 'Kỷ niệm mới chờ duyệt', 'Hirra đã tạo kỷ niệm mới trong cộng đồng Girl Anime', '\"{\\\"memory_id\\\":8,\\\"community_slug\\\":\\\"girl-anime\\\",\\\"user_name\\\":\\\"Hirra\\\",\\\"user_avatar\\\":null}\"', 'http://127.0.0.1:8000/communities/girl-anime', 1, '2025-12-09 01:58:18', '2025-12-09 01:57:55', '2025-12-09 01:58:18'),
(18, 'U3203506368', 'memory_approved', 'Kỷ niệm đã được duyệt', 'Kỷ niệm của bạn trong cộng đồng Girl Anime đã được duyệt!', '\"{\\\"memory_id\\\":8,\\\"community_slug\\\":\\\"girl-anime\\\",\\\"community_name\\\":\\\"Girl Anime\\\"}\"', 'http://127.0.0.1:8000/communities/girl-anime', 1, '2025-12-09 02:00:20', '2025-12-09 01:58:24', '2025-12-09 02:00:20'),
(19, 'U3564188634', 'friend_request', 'Lời mời kết bạn mới', 'Miku đã gửi lời mời kết bạn cho bạn', '{\"friendship_id\":6,\"sender_id\":\"U7398765524\"}', 'http://127.0.0.1:8000/friends', 1, '2025-12-09 01:59:58', '2025-12-09 01:59:22', '2025-12-09 01:59:58');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `posts`
--

CREATE TABLE `posts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` varchar(20) NOT NULL,
  `community_id` bigint(20) UNSIGNED DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `category` enum('anime','manga','cosplay','discussion') DEFAULT NULL,
  `content` text NOT NULL,
  `is_hidden` tinyint(1) NOT NULL DEFAULT 0,
  `hidden_at` timestamp NULL DEFAULT NULL,
  `hidden_reason` varchar(255) DEFAULT NULL,
  `background` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `video` varchar(255) DEFAULT NULL,
  `views` int(11) NOT NULL DEFAULT 0,
  `likes` int(11) NOT NULL DEFAULT 0,
  `is_pinned` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `community_id`, `title`, `slug`, `category`, `content`, `is_hidden`, `hidden_at`, `hidden_reason`, `background`, `image`, `video`, `views`, `likes`, `is_pinned`, `created_at`, `updated_at`) VALUES
(6, 'U3203506368', NULL, 'lo', 'lo-XhQPNw', 'anime', 'lo', 0, NULL, NULL, NULL, 'posts/zHbSl9V1xSYGq5CuYdX0pBsaS8BmN9Ceuusk0F3C.jpg', NULL, 33, 0, 0, '2025-11-18 02:48:17', '2025-12-09 01:57:07');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `post_likes`
--

CREATE TABLE `post_likes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` varchar(20) NOT NULL,
  `post_id` bigint(20) UNSIGNED DEFAULT NULL,
  `likeable_id` bigint(20) UNSIGNED DEFAULT NULL,
  `likeable_type` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `post_likes`
--

INSERT INTO `post_likes` (`id`, `user_id`, `post_id`, `likeable_id`, `likeable_type`, `created_at`, `updated_at`) VALUES
(16, 'U3564188634', 6, 6, 'App\\Models\\Post', '2025-11-19 02:39:09', '2025-11-19 02:39:09'),
(27, 'U3203506368', NULL, 1, 'App\\Models\\CommunityPost', '2025-12-02 06:53:05', '2025-12-02 06:53:05'),
(28, 'U3203506368', 6, NULL, NULL, '2025-12-09 01:11:29', '2025-12-09 01:11:29');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `post_reports`
--

CREATE TABLE `post_reports` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `post_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `reason` text NOT NULL,
  `status` enum('pending','reviewed','dismissed') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `post_tag`
--

CREATE TABLE `post_tag` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `post_id` bigint(20) UNSIGNED NOT NULL,
  `tag_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tags`
--

CREATE TABLE `tags` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `color` varchar(255) NOT NULL DEFAULT '#8B7FD8',
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `uid` varchar(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` enum('user','admin') NOT NULL DEFAULT 'user',
  `bio` text DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `profile_photo` varchar(255) DEFAULT NULL,
  `cover_photo` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`uid`, `name`, `email`, `role`, `bio`, `email_verified_at`, `password`, `profile_photo`, `cover_photo`, `remember_token`, `created_at`, `updated_at`) VALUES
('U3203506368', 'Hirra', 'trongbadboy9@gmail.com', 'admin', NULL, NULL, '$2y$12$L3CJ81P29Cwf094/O4zJ5.q65A59yngbptiAMFHR4WH/URSXuq15W', 'avatars/Zu6wRloSZG0EG1RhzrixetsBjmRe12YEtubGzsuz.jpg', 'covers/O1HCw3An3tYNIUoHgGd8dDqKu7DkvVlkA6mGN1QH.jpg', NULL, '2025-11-16 13:04:31', '2025-11-16 13:08:02'),
('U3564188634', 'Nguyen', 'lnguyen0305@gmail.com', 'user', 'cute dth', NULL, '$2y$12$HGhg2XOsr01.iAijcBNpseApUkG5.AYRiKCknkLl2DqONHvMZ.sh2', 'profile_photos/JRTHoZuCHT9HYTtczaqGqWrr8hYia2aDyXnosqKh.webp', 'covers/TSsSo1F7nTKAXXrYZ63dBGcZzaAhVgcAHEIaNKKA.jpg', NULL, '2025-11-18 04:56:52', '2025-11-19 02:40:44'),
('U7398765524', 'Miku', 'trongdc.24itb@vku.udn.vn', 'user', NULL, NULL, '$2y$12$PVfkOXhR3BBpaFDjEpTRjuO8ArhB1AFwicM.onLOsJ2XJPTvpPM7y', 'avatars/cYp7DSnNgO4t7t1LwWIpfgr3KyTlLtpiWazkBwaG.jpg', 'covers/QHQxjH2Q79MYcZZp16o9JbVeZ0hw46SzKILyLX6K.jpg', NULL, '2025-11-16 23:52:31', '2025-11-16 23:53:49'),
('U7454161379', 'Văn Tấnn', 'bread9126@gmail.com', 'user', NULL, NULL, '$2y$12$JBN8c1Ws50ZQGxWqdCN/qeL2F2LbwrtamkAmT8a3dCzewBaXRtFly', 'profile_photos/xDPjWkb9eFZ4QAZwhEPnC24UnLxRoaQA4RU3puZo.jpg', NULL, NULL, '2025-12-03 07:54:06', '2025-12-03 07:54:31');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comments_post_id_foreign` (`post_id`),
  ADD KEY `comments_user_id_foreign` (`user_id`);

--
-- Chỉ mục cho bảng `communities`
--
ALTER TABLE `communities`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `communities_slug_unique` (`slug`),
  ADD KEY `communities_user_id_foreign` (`user_id`);

--
-- Chỉ mục cho bảng `community_activities`
--
ALTER TABLE `community_activities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `community_activities_community_id_foreign` (`community_id`),
  ADD KEY `community_activities_user_id_foreign` (`user_id`),
  ADD KEY `community_activities_post_id_foreign` (`post_id`);

--
-- Chỉ mục cho bảng `community_members`
--
ALTER TABLE `community_members`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `community_members_community_id_user_id_unique` (`community_id`,`user_id`),
  ADD KEY `community_members_user_id_foreign` (`user_id`);

--
-- Chỉ mục cho bảng `community_memories`
--
ALTER TABLE `community_memories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `community_memories_user_id_foreign` (`user_id`),
  ADD KEY `community_memories_community_id_created_at_index` (`community_id`,`created_at`);

--
-- Chỉ mục cho bảng `community_messages`
--
ALTER TABLE `community_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `community_messages_community_id_created_at_index` (`community_id`,`created_at`),
  ADD KEY `community_messages_user_id_index` (`user_id`);

--
-- Chỉ mục cho bảng `community_posts`
--
ALTER TABLE `community_posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `community_posts_approved_by_foreign` (`approved_by`),
  ADD KEY `community_posts_community_id_status_index` (`community_id`,`status`),
  ADD KEY `community_posts_user_id_created_at_index` (`user_id`,`created_at`),
  ADD KEY `community_posts_reviewed_by_foreign` (`reviewed_by`);

--
-- Chỉ mục cho bảng `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `events_slug_unique` (`slug`),
  ADD KEY `events_user_id_foreign` (`user_id`);

--
-- Chỉ mục cho bảng `event_notifications`
--
ALTER TABLE `event_notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_notifications_event_id_foreign` (`event_id`),
  ADD KEY `event_notifications_user_id_is_read_index` (`user_id`,`is_read`);

--
-- Chỉ mục cho bảng `event_participants`
--
ALTER TABLE `event_participants`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `event_participants_event_id_user_id_unique` (`event_id`,`user_id`),
  ADD KEY `event_participants_user_id_foreign` (`user_id`);

--
-- Chỉ mục cho bảng `friendships`
--
ALTER TABLE `friendships`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `friendships_user_id_friend_id_unique` (`user_id`,`friend_id`),
  ADD KEY `friendships_friend_id_foreign` (`friend_id`);

--
-- Chỉ mục cho bảng `memory_reactions`
--
ALTER TABLE `memory_reactions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `memory_reactions_memory_id_user_id_unique` (`memory_id`,`user_id`),
  ADD KEY `memory_reactions_user_id_foreign` (`user_id`);

--
-- Chỉ mục cho bảng `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `messages_receiver_id_foreign` (`receiver_id`),
  ADD KEY `messages_sender_id_receiver_id_index` (`sender_id`,`receiver_id`),
  ADD KEY `messages_created_at_index` (`created_at`);

--
-- Chỉ mục cho bảng `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_user_id_is_read_created_at_index` (`user_id`,`is_read`,`created_at`),
  ADD KEY `notifications_type_index` (`type`);

--
-- Chỉ mục cho bảng `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Chỉ mục cho bảng `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `posts_slug_unique` (`slug`),
  ADD KEY `posts_user_id_foreign` (`user_id`),
  ADD KEY `posts_community_id_foreign` (`community_id`);

--
-- Chỉ mục cho bảng `post_likes`
--
ALTER TABLE `post_likes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `post_likes_user_id_post_id_unique` (`user_id`,`post_id`),
  ADD KEY `post_likes_post_id_foreign` (`post_id`);

--
-- Chỉ mục cho bảng `post_reports`
--
ALTER TABLE `post_reports`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `post_reports_post_id_user_id_unique` (`post_id`,`user_id`);

--
-- Chỉ mục cho bảng `post_tag`
--
ALTER TABLE `post_tag`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_tag_post_id_foreign` (`post_id`),
  ADD KEY `post_tag_tag_id_foreign` (`tag_id`);

--
-- Chỉ mục cho bảng `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tags_name_unique` (`name`),
  ADD UNIQUE KEY `tags_slug_unique` (`slug`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`uid`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_uid_unique` (`uid`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `comments`
--
ALTER TABLE `comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT cho bảng `communities`
--
ALTER TABLE `communities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `community_activities`
--
ALTER TABLE `community_activities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `community_members`
--
ALTER TABLE `community_members`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `community_memories`
--
ALTER TABLE `community_memories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `community_messages`
--
ALTER TABLE `community_messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `community_posts`
--
ALTER TABLE `community_posts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `events`
--
ALTER TABLE `events`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `event_notifications`
--
ALTER TABLE `event_notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `event_participants`
--
ALTER TABLE `event_participants`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `friendships`
--
ALTER TABLE `friendships`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `memory_reactions`
--
ALTER TABLE `memory_reactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT cho bảng `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT cho bảng `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT cho bảng `posts`
--
ALTER TABLE `posts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `post_likes`
--
ALTER TABLE `post_likes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT cho bảng `post_reports`
--
ALTER TABLE `post_reports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `post_tag`
--
ALTER TABLE `post_tag`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `tags`
--
ALTER TABLE `tags`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`uid`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `communities`
--
ALTER TABLE `communities`
  ADD CONSTRAINT `communities_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`uid`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `community_activities`
--
ALTER TABLE `community_activities`
  ADD CONSTRAINT `community_activities_community_id_foreign` FOREIGN KEY (`community_id`) REFERENCES `communities` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `community_activities_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `community_activities_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`uid`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `community_members`
--
ALTER TABLE `community_members`
  ADD CONSTRAINT `community_members_community_id_foreign` FOREIGN KEY (`community_id`) REFERENCES `communities` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `community_members_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`uid`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `community_memories`
--
ALTER TABLE `community_memories`
  ADD CONSTRAINT `community_memories_community_id_foreign` FOREIGN KEY (`community_id`) REFERENCES `communities` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `community_memories_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`uid`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `community_messages`
--
ALTER TABLE `community_messages`
  ADD CONSTRAINT `community_messages_community_id_foreign` FOREIGN KEY (`community_id`) REFERENCES `communities` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `community_messages_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`uid`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `community_posts`
--
ALTER TABLE `community_posts`
  ADD CONSTRAINT `community_posts_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`uid`) ON DELETE SET NULL,
  ADD CONSTRAINT `community_posts_community_id_foreign` FOREIGN KEY (`community_id`) REFERENCES `communities` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `community_posts_reviewed_by_foreign` FOREIGN KEY (`reviewed_by`) REFERENCES `users` (`uid`) ON DELETE SET NULL,
  ADD CONSTRAINT `community_posts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`uid`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`uid`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `event_notifications`
--
ALTER TABLE `event_notifications`
  ADD CONSTRAINT `event_notifications_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `event_notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`uid`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `event_participants`
--
ALTER TABLE `event_participants`
  ADD CONSTRAINT `event_participants_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `event_participants_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`uid`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `friendships`
--
ALTER TABLE `friendships`
  ADD CONSTRAINT `friendships_friend_id_foreign` FOREIGN KEY (`friend_id`) REFERENCES `users` (`uid`) ON DELETE CASCADE,
  ADD CONSTRAINT `friendships_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`uid`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `memory_reactions`
--
ALTER TABLE `memory_reactions`
  ADD CONSTRAINT `memory_reactions_memory_id_foreign` FOREIGN KEY (`memory_id`) REFERENCES `community_memories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `memory_reactions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`uid`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_receiver_id_foreign` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`uid`) ON DELETE CASCADE,
  ADD CONSTRAINT `messages_sender_id_foreign` FOREIGN KEY (`sender_id`) REFERENCES `users` (`uid`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`uid`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_community_id_foreign` FOREIGN KEY (`community_id`) REFERENCES `communities` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `posts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`uid`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `post_likes`
--
ALTER TABLE `post_likes`
  ADD CONSTRAINT `post_likes_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `post_likes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`uid`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `post_reports`
--
ALTER TABLE `post_reports`
  ADD CONSTRAINT `post_reports_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `post_tag`
--
ALTER TABLE `post_tag`
  ADD CONSTRAINT `post_tag_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `post_tag_tag_id_foreign` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
DELETE FROM migrations WHERE migration LIKE '%session%';
SELECT * FROM migrations WHERE migration LIKE '%session%';
