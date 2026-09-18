# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## What this repo is

This is the **WordPress document root** for the VVV site `almicahealing` (`almicahealing.test`) — the Álmica Healing marketing site, in early scaffolding. It is a standalone git repo (`main`, remote `git@klaritty-almica-github:klaritty-sde/almicahealing.git`) that happens to live inside a WordPress install: WordPress core is present on disk but deliberately untracked.

Three nested directories, three different rule sets — know which one you are in:

| Path | What it is | Git |
|---|---|---|
| `/Users/ianmeza/vvv-local/` | VVV, the Vagrant environment that hosts the site | Its own repo; see its `CLAUDE.md` |
| `…/www/almicahealing/` | VVV's clone of `custom-site-template` (the provisioner) | **Never commit here** — VVV hard-resets it to the remote on every provision |
| `…/www/almicahealing/public_html/` | **This repo** — the site's own code | Commit only custom theme/plugin/mu-plugin code |

The parent `CLAUDE.md` at `/Users/ianmeza/vvv-local/CLAUDE.md` also loads in this session and governs the VVV side. It is authoritative for anything about provisioning, `config.yml`, or the VVV repo boundary; do not duplicate or contradict it.

## The .gitignore allowlist (read before your first commit)

`.gitignore` denies everything at the WordPress root (`/*`) and re-allows a short list:

```
!/wp-content/themes/almicahealing/
!/wp-content/plugins/almicahealing-core/
!/wp-content/mu-plugins/almicahealing-analytics.php
!/wp-content/mu-plugins/almicahealing-environment.php
```

None of these directories/files exist yet — the theme (Phase 5) and plugin/mu-plugins (Phase 6) are still to be scaffolded from the Álmica Healing design. Add a new `!` line for each additional custom theme/plugin you create; if `git status` doesn't show a file you expect, the allowlist is the reason — fix the allowlist rather than reaching for `git add -f`.

Never track: WordPress core, the bundled `twentytwenty*` themes, `akismet`/`hello.php`, `wp-content/uploads/`, or `wp-config.php` (the provisioner generates it, and it holds the local DB credentials and salts).

## Environment facts

Established by the `almicahealing:` block in `/Users/ianmeza/vvv-local/config/config.yml` — that block, not any file here, is what creates this site:

- URL `https://almicahealing.test` (VVV issues the local TLS cert)
- WordPress **7.1**, PHP **8.2**, single-site install, locale `es_MX`
- DB `almicahealing`, user `wp`, password `wp`, host `localhost` (inside the VM)
- `WP_ENVIRONMENT_TYPE=local`, `WP_DEBUG`/`WP_DEBUG_LOG`/`SCRIPT_DEBUG` all on
- Default plugins removed (`delete_default_plugins: true`); `query-monitor` installed
- VM runs under the **Docker** provider (`vagrant status` from the VVV root)

**There is no staging environment for this project.** Production is the only remote environment; work directly against it per the plan (`PLAN-NEW-SITE-FROM-KLARITTY.md`), with backups before any destructive DB action.

Re-provisioning (`vagrant provision --provision-with site-almicahealing` from the VVV root) preserves `public_html/` — the provisioner skips the WP install when one is present — but it *does* hard-reset the parent `www/almicahealing/` template repo.

## Production

- SSH alias: `cloudways-almica-prod` (see `~/.ssh/config`) — Cloudways Flexible app, WP-CLI available.
- Remote root: `/home/1526072.cloudwaysapps.com/mpxfhevyqq/public_html` (auto-detected and cached by the sync script — don't hardcode it elsewhere).
- **No domain is mapped yet.** `siteurl`/`home` are still the Cloudways-issued `wordpress-1526072-6672333.cloudwaysapps.com` URL; SSL/email/domain setup is being done manually in the Cloudways console (Phase 1 of the plan), not from this repo.
- Prod currently runs a stock WordPress install (`twentytwentyfive`/`twentytwentyfour`/`twentytwentythree`, no custom theme) — there is nothing to pull down yet. `bin/almicahealing-sync` exists for when that changes and for future DB pulls.

## Commands

**There is no `wp` on the host.** Route WP-CLI through the VM:

```bash
cd /Users/ianmeza/vvv-local && vagrant ssh -c "cd /srv/www/almicahealing/public_html && wp theme list"
cd /Users/ianmeza/vvv-local && vagrant ssh -c "cd /srv/www/almicahealing/public_html && wp plugin list"
cd /Users/ianmeza/vvv-local && vagrant ssh -c "cd /srv/www/almicahealing/public_html && wp option get home"
```

Host paths map to the VM as `www/almicahealing/public_html` → `/srv/www/almicahealing/public_html`. The mount is live, so host edits take effect immediately with no provision.

Pull theme/plugin code down from production — `bin/almicahealing-sync` (symlinked into `~/.local/bin`, runs from anywhere). **Pull-only, never writes to production**:

```bash
almicahealing-sync -n                     # dry run: show what would change
almicahealing-sync                        # pull the almicahealing theme
almicahealing-sync --plugin <slug>        # pull a plugin instead
almicahealing-sync --delete               # also prune local files gone from prod (prompts)
almicahealing-sync --refresh              # re-detect the remote WordPress root
```

Override via env: `ALMICAHEALING_REMOTE_HOST`, `ALMICAHEALING_REMOTE_WP_ROOT`, `ALMICAHEALING_LOCAL_WP_ROOT`. Excluded from every pull: `.git/`, `node_modules/`, `.DS_Store`, `.idea/`.

Database (inside the VM):

```bash
cd /Users/ianmeza/vvv-local && vagrant ssh -c "mysql -u wp -pwp almicahealing -e 'SHOW TABLES;'"
```

PHP lint and WordPress coding standards — `phpcs` lives in the VM at `/srv/www/phpcs/bin/phpcs`. This repo ships `phpcs.xml.dist`, so no `--standard` flag is needed once the theme/plugin directories it references exist:

```bash
cd /Users/ianmeza/vvv-local && vagrant ssh -c "cd /srv/www/almicahealing/public_html && /srv/www/phpcs/bin/phpcs"
```

Node is on the **host**, not in the VM: run JS/CSS builds from the host, PHP tooling in the VM (see Phase 7 of the plan for the build setup once the theme exists).

Logs — `WP_DEBUG` and `SCRIPT_DEBUG` are both on:

```bash
tail -f /Users/ianmeza/vvv-local/www/almicahealing/log/nginx-error.log
tail -f /Users/ianmeza/vvv-local/www/almicahealing/log/nginx-access.log
```

## Deployment

No CI/deploy pipeline exists yet (Phase 9 of the plan). Until it does, **do not** push code to production by hand outside of what the plan's Phase 9 describes — no ad hoc SFTP/rsync pushes, no Cloudways "push to live". `almicahealing-sync` is intentionally pull-only.

## Issue tracking

Work on this repo is tracked in YouTrack, project **Klaritty Work** (short name `KW`), filtered by the **Klaritty Client** custom field set to **Almica**. When creating, searching, or updating issues for this codebase, scope them to that project/client rather than asking which one to use.

YouTrack MCP connectivity is configured via `.ai/mcp/mcp.json` (git-ignored — it holds a bearer token), symlinked to `.mcp.json` at this repo's root so Claude Code's project-scoped MCP config and any other tool reading `.ai/mcp/mcp.json` stay in sync. The server must be approved once per machine (`claude mcp list` shows pending/connected status).
