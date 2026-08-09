# Changelog

All important changes to this role are listed here.

## [3.0.0] - 2026-08-09

- **Enterprise Linux 9 support.** The role now installs the EPEL repository on all Red Hat family systems, not only on Oracle Linux. Package names were fixed for EL 9.
- **Safer configuration deploy.** The role builds the Nagios configuration in a temporary folder and runs `nagios -v` on it. Files are copied to the server only if the check passes.
- **It does not overwrite an existing configuration.** By default the role writes the base monitoring objects only where nothing exists yet, so it can share a server with another role that owns the configuration. The new variable `nagioscore_config_mode` also accepts `always` and `never`.
- **pnp4nagios runs on modern systems.** It now uses a systemd unit, keeps its data in `/var/lib/pnp4nagios`, and works with SELinux in enforcing mode and PHP 8.
