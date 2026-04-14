<div align="center">

<img src="https://raw.githubusercontent.com/devicons/devicon/master/icons/docker/docker-original-wordmark.svg" width="80" alt="Docker"/>

# 🐳 docker-php

### A containerized Employee Directory built with PHP 8.2 + Apache — deployed on AWS EC2

[![PHP](https://img.shields.io/badge/PHP-8.2-777BB4?style=flat-square&logo=php&logoColor=white)](https://php.net)
[![Docker](https://img.shields.io/badge/Docker-Ready-2496ED?style=flat-square&logo=docker&logoColor=white)](https://docker.com)
[![Apache](https://img.shields.io/badge/Apache-Webserver-D22128?style=flat-square&logo=apache&logoColor=white)](https://httpd.apache.org)
[![AWS EC2](https://img.shields.io/badge/AWS-EC2-FF9900?style=flat-square&logo=amazonaws&logoColor=white)](https://aws.amazon.com/ec2)
[![License: MIT](https://img.shields.io/badge/License-MIT-22c55e?style=flat-square)](LICENSE)

<br/>

> **TeamBoard** — A sleek, single-page employee directory dashboard.  
> Filter by department, search by name, add new team members live — all wrapped in Docker.

<br/>

![Preview Banner](https://img.shields.io/badge/Live%20Preview-18.224.202.198-00d4ff?style=for-the-badge)

</div>

---

## ✨ Features

| Feature | Description |
|---|---|
| 👥 **Employee Cards** | Beautiful cards with name, role, email, phone & join date |
| 🔍 **Live Search** | Filter employees by name or role instantly |
| 🏷️ **Dept Filters** | One-click filter buttons per department |
| ➕ **Add Employee** | Form to add new members — shows instantly without page reload |
| 🐳 **Dockerized** | One command to build & run anywhere |
| ☁️ **EC2 Ready** | Designed for AWS EC2 deployment on port 80 |
| 📱 **Responsive** | Works on mobile, tablet, and desktop |

---

## 📁 Project Structure

```
docker-php/
├── index.php        ← Full app (PHP + HTML + CSS + JS)
├── Dockerfile       ← Container build instructions
└── README.md        ← You are here
```

---

## 🐳 Docker — Quick Start

### 1. Clone the repo

```bash
git clone https://github.com/ahmadansari1942/docker-php.git
cd docker-php
```

### 2. Build the Docker image

```bash
docker build -t emp-app .
```

> **What happens here?**  
> Docker reads the `Dockerfile`, pulls `php:8.2-apache` as base, copies `index.php` into `/var/www/html/`, and creates a ready-to-run image named `emp-app`.

### 3. Run the container

```bash
docker run -d -p 80:80 emp-app
```

| Flag | Meaning |
|---|---|
| `-d` | Detached mode — runs in background |
| `-p 80:80` | Maps EC2/host port 80 → container port 80 |
| `emp-app` | Name of the image to use |

### 4. Open in browser

```
http://localhost
```

---

## 📄 Dockerfile — Explained

```dockerfile
# Base Image: PHP 8.2 + Apache bundled together
# No need to install PHP or Apache separately — ek image mein dono!
FROM php:8.2-apache

# Apache serves files from /var/www/html/ by default
# We copy our app there so it runs when a browser hits the IP
COPY index.php /var/www/html/

# Declaration only — tells Docker this container listens on port 80
# Actual port binding happens at `docker run -p 80:80`
EXPOSE 80
```

---

## ☁️ Deploy on AWS EC2

### Step 1 — Launch EC2 & SSH in

Use Amazon Linux 2 (free tier). Once connected via SSH:

### Step 2 — Install Docker & Git

```bash
sudo yum update -y
sudo yum install docker git -y
sudo systemctl start docker
sudo systemctl enable docker   # auto-start on reboot
```

### Step 3 — Clone & Build

```bash
sudo git clone https://github.com/ahmadansari1942/docker-php.git
cd docker-php
sudo docker build -t emp-app .
sudo docker run -d -p 80:80 emp-app
```

### Step 4 — Allow HTTP in Security Group

Go to: **AWS Console → EC2 → Security Groups → Inbound Rules**

| Type | Protocol | Port | Source |
|---|---|---|---|
| HTTP | TCP | 80 | 0.0.0.0/0 |

Now visit: `http://<your-ec2-public-ip>`

---

## 🔄 Update & Redeploy

When you push new code to GitHub, redeploy on EC2 like this:

```bash
# On your local machine
git add .
git commit -m "your update"
git push

# On EC2
cd docker-php
sudo git pull
sudo docker stop $(sudo docker ps -q)
sudo docker rm $(sudo docker ps -aq)
sudo docker build -t emp-app .
sudo docker run -d -p 80:80 emp-app
```

---

## 🛠️ Useful Docker Commands

```bash
# List running containers
docker ps

# View container logs
docker logs <container_id>

# Stop all running containers
docker stop $(docker ps -q)

# Remove all stopped containers
docker rm $(docker ps -aq)

# Check Docker service status
sudo systemctl status docker

# See all local images
docker images
```

---

## 💻 Tech Stack

<div align="center">

| Layer | Technology |
|---|---|
| 🖥️ Language | PHP 8.2 |
| 🌐 Web Server | Apache (httpd) |
| 🐳 Container | Docker |
| ☁️ Cloud | AWS EC2 (Amazon Linux) |
| 🎨 Frontend | Vanilla HTML/CSS/JS |
| 🔤 Fonts | Google Fonts (Syne + DM Sans) |

</div>

---

## 📸 Preview

```
┌─────────────────────────────────────────────┐
│  TeamBoard          [Directory] [Add] [Docker]│
├─────────────────────────────────────────────┤
│                                             │
│  Your Team,        ┌────────┬────────┐     │
│  All In One Place. │  8     │  6  2  │     │
│                    │ Total  │Active Rem│    │
│  [View Directory]  └────────┴────────┘     │
│  [Add Member]                               │
├─────────────────────────────────────────────┤
│  Employee Directory            8 members    │
│  [All][IT][Dev][Design][Testing][Mgmt]  🔍  │
│  ┌───────────────┐  ┌───────────────┐       │
│  │ AA  Ahmad     │  │ SK  Sara Khan │       │
│  │  DevOps · IT  │  │ Frontend·Dev  │       │
│  │ ✅ Active     │  │ ✅ Active     │       │
│  └───────────────┘  └───────────────┘       │
└─────────────────────────────────────────────┘
```

---

## 🤝 Contributing

1. Fork this repo
2. Create a branch: `git checkout -b feature/my-feature`
3. Commit your changes: `git commit -m 'Add feature'`
4. Push: `git push origin feature/my-feature`
5. Open a Pull Request

---

<div align="center">

Made with ❤️ by **[@ahmadansari1942](https://github.com/ahmadansari1942)**

⭐ Star this repo if you found it helpful!

</div>
