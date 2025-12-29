-- Migration: Add type column to posts and gallery tables
-- Type: portrait, landscape, square

USE smkweb;

-- Add type column to posts table
ALTER TABLE posts 
ADD COLUMN type ENUM('portrait', 'landscape', 'square') DEFAULT 'landscape' 
AFTER featured_image;

-- Add type column to gallery table
ALTER TABLE gallery 
ADD COLUMN type ENUM('portrait', 'landscape', 'square') DEFAULT 'square' 
AFTER image;

-- Update existing records with default type based on common patterns
-- You can manually update these later through admin panel

