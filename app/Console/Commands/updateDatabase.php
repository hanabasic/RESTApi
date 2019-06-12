<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use DB;
use App\User;
use App\Post;

class updateDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'database:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update database';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $client = new Client(); //GuzzleHttp\Client
        $responseUsers = $client->get('http://jsonplaceholder.typicode.com/users');
        $data = $responseUsers->getBody();
        $users = (object) json_decode($data, true);
        foreach ($users as $key => $user) {
            User::updateOrInsert([
                'id' => $user['id']],[
                'name' => $user['name'],
                'username' => $user['username'],
                'email' => $user['email']
            ]);
        }

        $responsePosts = $client->get('http://jsonplaceholder.typicode.com/posts');
        $dataPosts = $responsePosts->getBody();
        $posts = (object) json_decode($dataPosts,true);
        foreach ($posts as $key => $post) {
            Post::updateOrInsert([
                'id' => $post['id']],[
                'userId' => $post['userId'],
                'title' => $post['title'],
                'body' => $post['body']
            ]);
        }
    }
}
