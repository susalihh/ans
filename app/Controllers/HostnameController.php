<?php
namespace App\Controllers;

use Liman\Toolkit\Shell\Command;

class HostnameController
{
	public function get()
	{
		return respond(Command::run('hostname'), 200);
	}

	public function getClient()
	{
		$playbookname_field = request('playbookname');
		$sudopass_field = request('sudopass');
		
		Command::run("touch ansible_lab/test.txt");
		Command::run("ansible-playbook ansible_lab/@{:playbookname_field} --extra-vars 'ansible_sudo_pass=@{:sudopass_field}'", [
			'playbookname_field' => $playbookname_field,
			'sudopass_field' => $sudopass_field
		]);

		$output = Command::run('cat ansible_lab/test.txt');
		Command::run("rm ansible_lab/test.txt");
		if($output == "")
		$output="Hata";
		
		return respond($output, 200);
	}
	
	public function listHosts()
    {
		$playbookname_field = request('playbookname');
		$sudopass_field = request('sudopass');
		
		Command::run("touch ansible_lab/test.txt");
		Command::run("ansible-playbook ansible_lab/@{:playbookname_field} --extra-vars 'ansible_sudo_pass=@{:sudopass_field}'", [
			'playbookname_field' => $playbookname_field,
			'sudopass_field' => $sudopass_field
		]);

		$output = Command::run('cat ansible_lab/test.txt');
		Command::run("rm ansible_lab/test.txt");
		if($output == "")
		    $output="Hata";

        $fileJson = [];

        if ($output != '') {
            $fileArray = explode("\n", $output);
            $fileJson = collect($fileArray)->map(function ($i) {
                return ['name' => $i];
            }, $fileArray);
        }
        return view('table', [
            "value" => $fileJson,
            "title" => ["Value"],
            "display" => ["name"],
        ]);
    }
}