select `posts`.`id` as `post_id`,
    `posts`.`user_id` as `author_id`,
    `users`.`name` as `author_name`,
    `profiles`.`username` as `author_username`,
    `profiles`.`pp` as `author_pp`,
    `posts`.`category_id`,
    `categories`.`name` as `category_name`,
    `categories`.`slug` as `category_slug`,
    `posts`.`title` as `post_title`,
    `posts`.`slug` as `post_slug`,
    `posts`.`thumbnail` as `post_thumbnail`,
    `posts`.`status` as `post_status`,
    `posts`.`parent_id` as `post_parent_id`,
    `posts`.`updated_at`
from `posts`
    inner join `users` on `users`.`id` = `posts`.`user_id`
    inner join `profiles` on `profiles`.`user_id` = `users`.`id`
    inner join `categories` on `categories`.`id` = `posts`.`category_id`
    inner join `post_tags` on `post_tags`.`post_id` = `posts`.`id`
    inner join `tags` on `tags`.`id` = `post_tags`.`tag_id`
where `tags`.`slug` = '193-woodworking';

select `posts`.`id` as `post_id`,
    `posts`.`user_id` as `author_id`,
    `users`.`name` as `author_name`,
    `profiles`.`username` as `author_username`,
    `profiles`.`pp` as `author_pp`,
    `posts`.`category_id`,
    `categories`.`name` as `category_name`,
    `categories`.`slug` as `category_slug`,
    `posts`.`title` as `post_title`,
    `posts`.`slug` as `post_slug`,
    `posts`.`thumbnail` as `post_thumbnail`,
    `posts`.`status` as `post_status`,
    `posts`.`parent_id` as `post_parent_id`,
    `posts`.`updated_at`
from `posts`
    inner join `users` on `users`.`id` = `posts`.`user_id`
    inner join `profiles` on `profiles`.`user_id` = `users`.`id`
    inner join `categories` on `categories`.`id` = `posts`.`category_id`
where `posts`.`status` = ?
    and (
        `posts`.`title` LIKE ?
        or `posts`.`excerpt` LIKE ?
        or `posts`.`body` LIKE ?
    )
group by `posts`.`id`
limit 2 offset 0;


select posts.id as post_id,
    posts.user_id as author_id,
    users.name as author_name,
    
    profiles.username as author_username,
    profiles.bio as author_bio,
    profiles.about as author_about,
    profiles.pp as author_pp,

    categories.name as category_name,
    categories.slug as category_slug,

    posts.category_id,
    posts.title as post_title,
    posts.slug as post_slug,
    posts.thumbnail as post_thumbnail,
    posts.status as post_status,
    posts.parent_id as post_parent_id,
    posts.updated_at
from posts  
    inner join users on users.id = posts.user_id
    inner join profiles on profiles.user_id = users.id
    inner join categories on categories.id = posts.category_id