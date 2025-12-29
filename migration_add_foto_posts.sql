-- Migration: Add column 'foto' to posts table
-- File: migration_add_foto_posts.sql

USE smkweb;

-- Add column 'foto' to posts table
ALTER TABLE posts 
ADD COLUMN foto VARCHAR(255) NULL AFTER featured_image;

-- Add index for better performance
CREATE INDEX idx_posts_foto ON posts(foto);

