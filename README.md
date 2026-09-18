# Álmica Healing

WordPress site for Álmica Healing, developed against a [VVV](https://varyingvagrantvagrants.org/) local environment. This repo is rooted at the WordPress docroot (`public_html`); see `CLAUDE.md` for the full repo-boundary rules and `PLAN-NEW-SITE-FROM-KLARITTY.md` for the build plan this project follows.

## Prerequisites

- [VVV](https://varyingvagrantvagrants.org/) checked out at `/Users/ianmeza/vvv-local` with Docker Desktop (or VirtualBox) and `vagrant`.
- Node (for the theme's frontend build, once it exists — see Phase 7 of the plan).
- SSH access to `cloudways-almica-prod` (see `~/.ssh/config`), for pulling from production only. There is no staging environment for this project.

## First-time setup

1. Add the `almicahealing:` block to `/Users/ianmeza/vvv-local/config/config.yml` (already present if you're reading this from a working checkout):
   ```yaml
   almicahealing:
     skip_provisioning: false
     description: "Almica Healing"
     repo: https://github.com/Varying-Vagrant-Vagrants/custom-site-template.git
     hosts:
       - almicahealing.test
     php: 8.2
     custom:
       wp_version: "7.1"
       db_name: almicahealing
       site_title: "Almica Healing"
       locale: es_MX
       delete_default_plugins: true
       install_plugins:
         - query-monitor
       wpconfig_constants:
         WP_ENVIRONMENT_TYPE: local
         WP_DEBUG: true
         WP_DEBUG_LOG: true
         SCRIPT_DEBUG: true
         WP_DISABLE_FATAL_ERROR_HANDLER: true
   ```
2. From `/Users/ianmeza/vvv-local`: `vagrant up --provision` (or `vagrant provision --provision-with site-almicahealing` if the VM is already running).
3. Confirm: `curl -sI https://almicahealing.test` returns 200.

## Cloning into an already-provisioned docroot

`git clone` refuses a non-empty directory, and the VVV site template already populated `public_html/` with a fresh WordPress install. Instead:

```bash
cd /Users/ianmeza/vvv-local/www/almicahealing/public_html
git init -b main && git remote add origin git@klaritty-almica-github:klaritty-sde/almicahealing.git
git fetch origin && git checkout -f -t origin/main
```

## Everyday commands

```bash
cd /Users/ianmeza/vvv-local && vagrant ssh -c "cd /srv/www/almicahealing/public_html && wp core version"
almicahealing-sync -n              # dry run: pull the theme from production
almicahealing-sync --plugin <slug> # pull a plugin from production
```

See `CLAUDE.md` for the full command reference (WP-CLI, phpcs, logs, the sync script).

## Build / lint

```bash
cd wp-content/themes/almicahealing && npm ci && npm run build   # once the theme exists (Phase 7)
vagrant ssh -c "cd /srv/www/almicahealing/public_html && /srv/www/phpcs/bin/phpcs"
```

## Deploy

No CI/deploy pipeline exists yet. Do not push to production by hand — see Phase 9 of the plan for the intended CI-driven rsync deploy once it's built.
