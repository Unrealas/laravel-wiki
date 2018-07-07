<?php

namespace App\Console\Commands;

use Faker\Factory;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class FakePost extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fakePost {params*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'First param - post count, second param - max rand title length';

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
//        $this->ask('What is your name?');
//        $this->secret('What is the password?');

/*        $this->confirm('Do you wish to continue?')) {

        }*/
        $i = 0;

        $params = $this ->argument('params');


        do{
            $faker = Factory::create();
            $this->info('Fake post uploading');
            DB::table('posts')->insert(
                [
                    'title' => $faker->text(rand (5, $params[1])),
                    'content' => $faker->text(555),
                    'user' => 1,
                    'category' => 1,
                    'created_at' => Date('Y-m-d H:i:s'),
                    'updated_at' => Date('Y-m-d H:i:s')
                ]
            );
            $i++;
        }while($i <= $params[0]);

        $this->line('Done!')
;    }
}
