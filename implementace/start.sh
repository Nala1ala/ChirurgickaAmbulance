#!/bin/bash

echo "==================================================="
echo "  Startuji Haasove chirurgickou ambulanci (Docker)"
echo "==================================================="
echo ""

echo "[1/3] Building and running Docker containers..."
docker-compose up -d --build

echo ""
echo "[2/3] Waiting for full load of Apache server..."
sleep 5

echo ""
echo "[3/3] Installing Composer dependencies..."
docker-compose exec web composer install

echo ""
echo "==================================================="
echo "  Aplikace by měla běžet na http://localhost:8888"
echo "==================================================="