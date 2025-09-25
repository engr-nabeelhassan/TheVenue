@echo off
title 🚀 Laravel + Cursor Runner

:: Root folder set karo
cd /d C:\Users\Shahjahan\Desktop\the_venue

:: Laravel backend start (background)
start /b composer run dev

:: Cursor editor open
cursor "%cd%"

:: CMD khula rakho
pause