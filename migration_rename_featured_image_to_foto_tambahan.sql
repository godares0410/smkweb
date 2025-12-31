-- Migration: Rename featured_image to foto_tambahan
-- Run this SQL in your database to rename the column

ALTER TABLE posts 
CHANGE COLUMN featured_image foto_tambahan VARCHAR(255) NULL;

