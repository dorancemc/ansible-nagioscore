# GitHub Actions example — draft

`deploy-nagios.yml` is a draft. It does **not** run from this repository. This
repository holds the role only, so it has no inventory and no secrets.

Copy the file to your own Ansible repository, into `.github/workflows/`, and adapt
it.

## Repository layout it expects

```
.github/workflows/deploy-nagios.yml
.yamllint.yml
ansible/ansible.cfg
ansible/playbooks/main.yml
ansible/requirements.yml
ansible/inventory/<environment>/hosts.ini
ansible/inventory/<environment>/group_vars/
```

If your paths are different, change the `ANSIBLE_CONFIG` environment variable and
the `INVENTORY` value in each job.

`ansible/requirements.yml` is where you pull this role in:

```yaml
---
roles:
  - name: dorancemc.ansible_nagioscore
    src: https://github.com/dorancemc/ansible_nagioscore
    scm: git
    version: v3.0.0
```

## Secrets you must create

| Secret | What it holds |
|---|---|
| `ANSIBLE_SSH_KEY` | Private key that can reach the Nagios servers |
| `ANSIBLE_KNOWN_HOSTS` | Output of `ssh-keyscan <host>` for every target host |
| `ANSIBLE_VAULT_PASSWORD` | The Ansible Vault password |

`ANSIBLE_KNOWN_HOSTS` is not optional. Without it the run fails on host key
checking. Do not fix that by turning host key checking off, because that removes
the protection against a man in the middle.

## Environments you must create

The `deploy` job uses `environment: <name>`. Create one GitHub Environment for each
option in the `environment` input: `development`, `staging` and `production`.

Add **required reviewers** to the environments that matter. That is what makes the
apply step wait for a human. Without reviewers the job runs with no approval.

## How it works

The workflow only starts from the Actions tab, with the "Run workflow" button.
There is no push or schedule trigger, so it never deploys by itself.

It runs three jobs in order:

1. **Lint** — `yamllint`, `ansible-lint` and a playbook syntax check.
2. **Dry run** — the playbook with `--check --diff`. Nothing is changed.
3. **Apply** — the real run. It only starts if you set the `apply` input to true,
   and it waits for approval if the environment has reviewers.

Inputs: pick the environment, and optionally set `limit` to a few hosts or `tags`
to a part of the role. The role tags are `nagioscore`, `nagioscore-install`,
`nagioscore-config`, `nagioscore-apache-config`, `nagioscore-nrdp`,
`nagioscore-nrdp-config` and `nagioscore-pnp4nagios`.

## Notes

The button only appears once the file is on your default branch. After that you can
run it against any branch.

`concurrency` stops two deploys to the same environment at the same time. Runs to
different environments are still parallel.

The free-text inputs are passed to the shell through environment variables, never
inserted directly into the script. Keep it that way, or a crafted input could run
commands on the runner.
