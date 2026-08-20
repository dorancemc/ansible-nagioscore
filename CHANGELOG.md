# Changelog

All important changes to this role are listed here.
## [4.0.0] - 2026-08-20

- **Breaking: monitoring objects moved out of this role.** Hosts, services, contacts, contactgroups, hostgroups, servicegroups, commands and all object templates are now owned by [`ansible_nagiosconfig`](https://github.com/dorancemc/ansible_nagiosconfig), which supports both Nagios Core and Nagios XI from the same data. Removed: the `nagioscore-config` tag, the `nagios_contacts`, `nagios_contactgroup`, `nagios_hostgroups`, `nagios_servicegroups`, `nagios_commands_definition`, `nagios_*_templates`, `nagios_timeperiods`, `nagios_base_path`, `nagios_hosts_path`, `nagios_clean_assets` and `nagioscore_config_mode` variables, and the object templates under `templates/nagios/etc/{assets,templates}`. `nagios.cfg`, `cgi.cfg`, `resource.cfg` and the `cfg_dir` directories stay here.
- **Breaking: the htpasswd file has its own variable.** Web users come from `nagioscore_htpasswd_users` (`user: {password, state}`) instead of the password field of `nagios_contacts`. Apache and its `AuthUserFile` are owned by this role, the contact objects are not.
- **New `bootstrap.cfg`.** One self-contained host, service, timeperiod and check command, so a fresh install with no objects still passes `nagios -v` and starts. It lives outside the directories `ansible_nagiosconfig` owns, so its `rsync --delete` never removes it. The perfdata processing commands stay in `ansible_nagiosconfig` — defining them here too would be a duplicate definition, and Nagios does not validate them at pre-flight.

## [3.0.2] - 2026-08-19

- Added service management, systemd overrides for nagios, and update host definition parsing logic
- Added `nagios_base_path` variable and implement dynamic loading of shared monitoring objects from inventory
- Replace direct variable loading with task-based dynamic discovery for monitoring objects and remove legacy user configurations
- Prevent overwriting existing apache configuration files by setting force to false
- Added support for installing custom Nagios plugins via external URLs
- Implement platform-specific command file paths 
- Added filter htpasswd generation to only include users with defined passwords

## [3.0.1] - 2026-08-09

- **SELinux is handled with real modules.** The role now uses `ansible.posix.seboolean` and `community.general.sefcontext` instead of shell commands, so the tasks are idempotent on their own. `policycoreutils-python-utils` is installed, because `sefcontext` needs it and not every image ships it.
- **Linting runs in CI.** A GitHub Actions workflow runs `yamllint`, `ansible-lint` and a syntax check on every push and pull request. An `.ansible-lint` file holds the project rules. Handler names were changed to start with a capital letter.
- **Fixed the minimum Ansible version.** `min_ansible_version` was written without quotes, so YAML read it as the number 2.2 instead of the version 2.20. The role was accepting Ansible releases from 2016.

## [3.0.0] - 2026-08-09

- **Enterprise Linux 9 support.** The role now installs the EPEL repository on all Red Hat family systems, not only on Oracle Linux. Package names were fixed for EL 9.
- **Safer configuration deploy.** The role builds the Nagios configuration in a temporary folder and runs `nagios -v` on it. Files are copied to the server only if the check passes.
- **It does not overwrite an existing configuration.** By default the role writes the base monitoring objects only where nothing exists yet, so it can share a server with another role that owns the configuration. The new variable `nagioscore_config_mode` also accepts `always` and `never`.
- **pnp4nagios runs on modern systems.** It now uses a systemd unit, keeps its data in `/var/lib/pnp4nagios`, and works with SELinux in enforcing mode and PHP 8.
