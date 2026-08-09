# Nagios Core

Deploy and configure Nagios Core with Apache, optional NRDP and PNP4Nagios, and monitoring object definitions.

By default the role writes the base monitoring objects only where nothing exists yet, so it can share a server with another role that owns the configuration.

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

Apply configuration only:

```bash
ansible-playbook --limit nagios playbook.yml --tags nagioscore-config
```

Tags: `nagioscore`, `nagioscore-install`, `nagioscore-config`, `nagioscore-apache-config`, `nagioscore-nrdp`, `nagioscore-nrdp-config`, `nagioscore-pnp4nagios`.

## Variables

Variables and their default values live in `defaults/`. They are not repeated here.

Credentials come from inventory vault variables: `vault_nagiosadmin_password`, `vault_rouser_password`, `vault_nrdp_mysecrettoken` and `vault_nrdp_myothertoken`.
