# Nagios Core

Install and configure Nagios Core with Apache, optional NRDP and PNP4Nagios.

This role installs the engine, it does not manage monitoring objects. Hosts, services, contacts, groups and templates belong to [`ansible_nagiosconfig`](https://github.com/dorancemc/ansible_nagiosconfig), which writes them into the `cfg_dir` directories declared here. The role ships a `bootstrap.cfg` with one self-contained host, service, timeperiod and check command, so a fresh install passes `nagios -v` and starts with no other objects present. The perfdata processing commands that `nagios.cfg` references belong to `ansible_nagiosconfig`: Nagios does not check them at pre-flight, so the engine starts without them, but performance data is not processed until that role runs.

## Requirements

- Ansible 2.20 or newer
- Target hosts running Enterprise Linux 9 (AlmaLinux, Rocky, RHEL, Oracle Linux), Debian 13, or Ubuntu 24.04
- Root privileges on target hosts

Amazon Linux 2023 is not supported.

## Example Playbook

```ini
[nagios]
nagios.example.com ansible_host=192.168.243.220
```

```yaml
- hosts: nagios
  become: true
  roles:
    - role: dorancemc.ansible_nagioscore
```

Apply the full role:

```bash
ansible-playbook --limit nagios playbook.yml --tags nagioscore
```

Tags: `nagioscore`, `nagioscore-install`, `nagioscore-apache-config`, `nagioscore-nrdp`, `nagioscore-nrdp-config`, `nagioscore-pnp4nagios`.

## Variables

Variables and their default values live in `defaults/`. They are not repeated here.

Web interface users live in `nagioscore_htpasswd_users`, a dict of `user: {password, state}` that owns the Apache `AuthUserFile`. It is independent of the Nagios contact objects, which belong to `ansible_nagiosconfig`.

Credentials come from inventory vault variables: `vault_nagiosadmin_password`, `vault_rouser_password`, `vault_nrdp_mysecrettoken` and `vault_nrdp_myothertoken`.
