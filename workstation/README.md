# Workstation setup using Docker

The setup works as a reverse proxy that redirects each domain to a separate project.
This way we can have multiple projects running on the same machine with their own separate containers.

Each project must be a [Docker](https://docs.docker.com/) project.

## Overview

- use [Portainer](https://www.portainer.io) instead of Docker Desktop to monitor containers, images, networks, etc.

- use [Traefik](https://doc.traefik.io/traefik/) as a reverse proxy to allow different urls to point to different Docker containers

- store each Traefic config as a separate file per project inside `/traefik` like:
  - `/traefik/z_{project-name-1}/`
  - `/traefik/z_{project-name-2}/`
  - ...

## How it works

- when you go to an url in the browser, the domain is checked inside Windows `hosts` file where it should point to `127.0.0.1` (localhost)

- at `127.0.0.1` we have WSL (or you can have a separate virtual machine but we recommend WSL) and at port `80` & `443` inside WSL we have the Traefik container that's intercepting the request

- using Traefik configs, Traefic identifies the domain and redirects the request to the project container that's associated to that domain

- in the associated project container you can have [Nginx](https://hub.docker.com/_/nginx) or [Apache](https://hub.docker.com/r/bitnami/apache) webserver that serves your PHP / JS code

## Installation

  - [install WSL 2 with Ubuntu](#install-wsl)

  - [install Docker inside WSL](#install-docker)

  - add `127.0.0.1 traefik.local.test` and `127.0.0.1 portainer.local.test` inside `C:\Windows\System32\drivers\etc\hosts`

  - **Important:** make sure you are not the **root** user. Login as the **fps** user and only use this user when developing.

  - run `cp .env.example .env`, then set the required configs inside `.env` file

  - give execute permissions to deploy file: `chmod 775 deploy.sh`

  - run file: `./deploy.sh`

  - Portainer (replacement for Docker Desktop) can be accessed at https://portainer.local.test

  - Traefik can be accessed at https://traefik.local.test

## Configuring your projects

For each project, we need to do the following:

- make sure you have your project docker compose file configured with all your required services. You can see examples inside `../docker-samples`

- as an example, we assume we want our project to be available at `my-project.local.test`

- add `127.0.0.1 my-project.local.test` inside `C:\Windows\System32\drivers\etc\hosts`

- make sure your webserver container is also in the `workstation_default` network and give it a **unique** alias in this network. Your webserver container must be in the same network where the Traefik container is running so that Traefik can see it. Inside your project docker compose file, you should have something like:

  ```
  services:
    ...

    # - the webserver container - this is the entrypoint in your project where Traefik will route the requests into
    # - you can use Nginx, Apache or any other web server
    webserver:
      image: nginx:1.27.1

      ...

      networks:
        workstation:
          aliases:
            - my-project-webserver # unique name not used by another project
  ...

  networks:
    workstation:
      external: true
      name: workstation_default

    ...
  ```

- create the Traefik config file for the project inside `/traefik/z_my-project.yml`.

  **Note**: The names `my-project-http` / `my-project-https` / `my-project-service` **must be unique** and not used in another configuration by another project.

  ```
  http:
    routers:
      my-project-http:
        rule: "Host(`my-project.local.test`)"
        entrypoints:
          - web
        service: my-project-service
        ## uncomment to redirect to https
        #middlewares: redirect-https@file

      ## uncomment for https
      #my-project-https:
      #  rule: "Host(`my-project.local.test`)"
      #  entrypoints:
      #    - websecure
      #  service: my-project-service
      #  tls: true

    services:
      my-project-service:
        loadBalancer:
          servers:
            - url: http://my-project-webserver
  ```

  - the above configuration will make `my-project.local.test` go inside WSL >> Traefik >> webserver container with alias `my-project-webserver` where you have your Nginx / Apache configurations that run your project

## Turn off

  - if you want to turn it off, run `docker compose down --remove-orphans`

## Docker Resources
  - [Learn Docker concepts](https://docs.docker.com/get-started/docker-concepts/the-basics/what-is-a-container/)
  - [Docker compose elements](https://docs.docker.com/reference/compose-file/)

# Install WSL

Install WSL with **Ubuntu**: https://learn.microsoft.com/en-us/windows/wsl/install

**Note:** You can then start WSL by going inside your terminal and running `wsl` command

**Important:** Make sure you create a non-root user called **fps** with password **fps**.

- `sudo adduser fps` (create new user **fps** with password **fps**)

- `sudo usermod -aG sudo fps` (make **fps** user able to sudo)

# Install Docker

Guide: https://docs.docker.com/engine/install/ubuntu

- Run the following command to uninstall all conflicting packages:

`for pkg in docker.io docker-doc docker-compose docker-compose-v2 podman-docker containerd runc; do sudo apt-get remove $pkg; done`

- Before you install Docker Engine for the first time on a new host machine, you need to set up the Docker repository. Afterward, you can install and update Docker from the repository.

  ```
  # Add Docker's official GPG key:
  sudo apt-get update
  sudo apt-get install ca-certificates curl
  sudo install -m 0755 -d /etc/apt/keyrings
  sudo curl -fsSL https://download.docker.com/linux/ubuntu/gpg -o /etc/apt/keyrings/docker.asc
  sudo chmod a+r /etc/apt/keyrings/docker.asc

  # Add the repository to Apt sources:
  echo \
    "deb [arch=$(dpkg --print-architecture) signed-by=/etc/apt/keyrings/docker.asc] https://download.docker.com/linux/ubuntu \
    $(. /etc/os-release && echo "$VERSION_CODENAME") stable" | \
    sudo tee /etc/apt/sources.list.d/docker.list > /dev/null
  sudo apt-get update
  ```

- Install the Docker packages:

  `sudo apt-get install docker-ce docker-ce-cli containerd.io docker-buildx-plugin docker-compose-plugin`

- Give **fps** user permissions to run Docker commands

  `sudo usermod -aG docker fps`