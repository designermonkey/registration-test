require 'yaml'
data = YAML.load_file "ansible/vars/all.yml"
vars = data['vagrant']['vm']

#If your Vagrant version is lower than 1.5, you can still use this provisioning
#by commenting or removing the line below and providing the config.vm.box_url parameter,
#if it's not already defined in this Vagrantfile. Keep in mind that you won't be able
#to use the Vagrant Cloud and other newer Vagrant features.
Vagrant.require_version ">= 1.5"

# Check to determine whether we're on a windows or linux/os-x host,
# later on we use this to launch ansible in the supported way
# source: https://stackoverflow.com/questions/2108727/which-in-ruby-checking-if-program-exists-in-path-from-ruby
def which(cmd)
    exts = ENV['PATHEXT'] ? ENV['PATHEXT'].split(';') : ['']
    ENV['PATH'].split(File::PATH_SEPARATOR).each do |path|
        exts.each { |ext|
            exe = File.join(path, "#{cmd}#{ext}")
            return exe if File.executable? exe
        }
    end
    return nil
end

Vagrant.configure("2") do |config|

    config.vm.provider :virtualbox do |v|
        v.name = vars['hostname']
        v.customize [
            "modifyvm", :id,
            "--name", vars['hostname'],
            "--memory", vars['memory'],
            "--natdnshostresolver1", "on",
            "--cpus", 1,
        ]
    end

    config.vm.box = vars['base_box']
    config.vm.network :private_network, ip: vars['ip']
    config.vm.synced_folder "./", "/vagrant"
    config.vm.hostname = vars['hostname'];
    config.vm.network "forwarded_port", guest: 9485, host: 9485

    config.ssh.forward_agent = true
    config.ssh.insert_key = true

    config.hostmanager.enabled = true
    config.hostmanager.manage_host = true
    config.hostmanager.manage_guest = true
    config.hostmanager.ignore_private_ip = false
    config.hostmanager.include_offline = true

    config.vm.provision :shell do |shell|
        shell.inline = "touch $1 && chmod 0440 $1 && echo $2 > $1"
        shell.args = %q{/etc/sudoers.d/root_ssh_agent "Defaults env_keep += \"SSH_AUTH_SOCK\""}
    end

    # If ansible is in your path it will provision from your HOST machine
    # If ansible is not found in the path it will be instaled in the VM and provisioned from there
    if which('ansible-playbook')
        config.vm.provision "ansible" do |ansible|
            ansible.playbook = "ansible/playbook.yml"
            ansible.inventory_path = "ansible/inventories/dev"
            ansible.limit = 'all'
        end
    else
        config.vm.provision :shell, path: "ansible/windows.sh", args: [vars['hostname']]
    end

end
