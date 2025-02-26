<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class VideoLinksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $videos = [
            ['title' => 'Laravel Crash Course', 'video_links' => 'https://www.youtube.com/watch?v=laravel1'],
            ['title' => 'React.js Tutorial', 'video_links' => 'https://www.youtube.com/watch?v=react1'],
            ['title' => 'Vue.js Basics', 'video_links' => 'https://www.youtube.com/watch?v=vue1'],
            ['title' => 'Angular for Beginners', 'video_links' => 'https://www.youtube.com/watch?v=angular1'],
            ['title' => 'Node.js Express Tutorial', 'video_links' => 'https://www.youtube.com/watch?v=node1'],
            ['title' => 'Tailwind CSS Guide', 'video_links' => 'https://www.youtube.com/watch?v=tailwind1'],
            ['title' => 'Bootstrap 4 Basics', 'video_links' => 'https://www.youtube.com/watch?v=bootstrap1'],
            ['title' => 'Django Framework', 'video_links' => 'https://www.youtube.com/watch?v=django1'],
            ['title' => 'PHP for Beginners', 'video_links' => 'https://www.youtube.com/watch?v=php1'],
            ['title' => 'JavaScript ES6', 'video_links' => 'https://www.youtube.com/watch?v=js1'],
            ['title' => 'Python Flask Crash Course', 'video_links' => 'https://www.youtube.com/watch?v=flask1'],
            ['title' => 'MongoDB Database Guide', 'video_links' => 'https://www.youtube.com/watch?v=mongo1'],
            ['title' => 'MySQL Basics', 'video_links' => 'https://www.youtube.com/watch?v=mysql1'],
            ['title' => 'Git & GitHub Tutorial', 'video_links' => 'https://www.youtube.com/watch?v=git1'],
            ['title' => 'DevOps Essentials', 'video_links' => 'https://www.youtube.com/watch?v=devops1'],
        ];

        foreach ($videos as $video) {
            DB::table('video_links')->insert([
                'title' => $video['title'],
                'video_links' => $video['video_links'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
