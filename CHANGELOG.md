# Changelog

All important changes to this role are listed here.

## [3.0.1] - 2026-08-09

- **SELinux is handled with real modules.** The role now uses `ansible.posix.seboolean` and `community.general.sefcontext` instead of shell commands, so the tasks are idempotent on their own. `policycoreutils-python-utils` is installed, because `sefcontext` needs it and not every image ships it.
- **Linting runs in CI.** A GitHub Actions workflow runs `yamllint`, `ansible-lint` and a syntax check on every push and pull request. An `.ansible-lint` file holds the project rules. Handler names were changed to start with a capital letter.
- **Fixed the minimum Ansible version.** `min_ansible_version` was written without quotes, so YAML read it as the number 2.2 instead of the version 2.20. The role was accepting Ansible releases from 2016.

## [3.0.0] - 2026-08-09

- **Enterprise Linux 9 support.** The role now installs the EPEL repository on all Red Hat family systems, not only on Oracle Linux. Package names were fixed for EL 9.
- **Safer configuration deploy.** The role builds the Nagios configuration in a temporary folder and runs `nagios -v` on it. Files are copied to the server only if the check passes.
- **It does not overwrite an existing configuration.** By default the role writes the base monitoring objects only where nothing exists yet, so it can share a server with another role that owns the configuration. The new variable `nagioscore_config_mode` also accepts `always` and `never`.
- **pnp4nagios runs on modern systems.** It now uses a systemd unit, keeps its data in `/var/lib/pnp4nagios`, and works with SELinux in enforcing mode and PHP 8.
