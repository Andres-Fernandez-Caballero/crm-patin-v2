<?php

namespace Database\Seeders;

use App\Models\Topic;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TopicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $topics = [
            'PHP',
            'Laravel',
            'JavaScript',
            'Vue.js',
            'React.js',
            'Angular',
            'Node.js',
            'Python',
            'Django',
            'Flask',
            'Ruby',
            'Ruby on Rails',
            'Java',
            'Spring',
            'Kotlin',
            'Android',
            'C#',
            'ASP.NET',
            'SQL',
            'MySQL',
            'PostgreSQL',
            'MongoDB',
            'Docker',
            'Kubernetes',
            'AWS',
            'Azure',
            'Google Cloud',
            'Firebase',
            'Git',
            'GitHub',
            'GitLab',
            'Bitbucket',
            'Jenkins',
            'Netlify',
            'Vercel',
            'Digital Ocean',
            'Nginx',
            'Apache',
            'IIS',
            'Linux',
            'Ubuntu',
            'Debian',
            'Windows',
            'Android',
            'Raspberry Pi',
            'Arduino',
            ];

       
            foreach( Topic::all() as $topic){
                $topic->create([
                    'name' => $topic,
                ]);
            }
    }
}
