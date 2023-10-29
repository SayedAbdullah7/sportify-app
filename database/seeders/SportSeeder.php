<?php

namespace Database\Seeders;

use App\Models\Sport;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Sport::count() < 1){
            $sports = [
                'football',
                'basketball',
                'baseball',
                'soccer',
                'tennis',
                'volleyball',
                'golf',
                'hockey',
                'cricket',
                'rugby',
                'swimming',
                'cycling',
                'athletics',
                'badminton',
                'table tennis',
                'boxing',
                'wrestling',
                'gymnastics',
                'skiing',
                'snowboarding',
                'surfing',
                'skateboarding',
                'archery',
                'shooting',
                'equestrian',
                'weightlifting',
                'karate',
                'judo',
                'taekwondo',
                'fencing',
                'canoeing',
                'kayaking',
                'sailing',
                'rowing',
                'triathlon',
                'pentathlon',
                'bobsleigh',
                'luge',
                'skeleton',
                'curling',
                'figure skating',
                'ice hockey',
                'freestyle skiing',
                'biathlon',
                'water polo',
                'polo',
                'snooker',
                'billiards',
            ];

            $sportsWithPositions = [
                'football' => [
                    'Forward',
                    'Midfielder',
                    'Defender',
                    'Goalkeeper'
                ],
                'basketball' => [
                    'Point Guard',
                    'Shooting Guard',
                    'Small Forward',
                    'Power Forward',
                    'Center'
                ],
                'baseball' => [
                    'Pitcher',
                    'Catcher',
                    'First Baseman',
                    'Second Baseman',
                    'Third Baseman',
                    'Shortstop',
                    'Outfielder'
                ],
                'soccer' => [
                    'Forward',
                    'Midfielder',
                    'Defender',
                    'Goalkeeper'
                ],
                'tennis' => [
                    'Singles Player',
                    'Doubles Player'
                ],
                'volleyball' => [
                    'Setter',
                    'Outside Hitter',
                    'Middle Blocker',
                    'Opposite Hitter',
                    'Libero'
                ],
                'golf' => [
                    'Driver',
                    'Irons',
                    'Putter'
                ],
                'hockey' => [
                    'Forward',
                    'Defenseman',
                    'Goaltender'
                ],
                'cricket' => [
                    'Batsman',
                    'Bowler',
                    'All-Rounder',
                    'Wicketkeeper'
                ],
                'rugby' => [
                    'Prop',
                    'Hooker',
                    'Lock',
                    'Flanker',
                    'Number Eight',
                    'Scrum-half',
                    'Fly-half',
                    'Center',
                    'Wing',
                    'Fullback'
                ],
                'swimming' => [
                    'Freestyle',
                    'Butterfly',
                    'Backstroke',
                    'Breaststroke',
                    'Individual Medley'
                ],
                'cycling' => [
                    'Sprinter',
                    'Climber',
                    'Time Trialist',
                    'All-Rounder'
                ],
                'athletics' => [
                    'Sprinter',
                    'Middle Distance Runner',
                    'Long Distance Runner',
                    'Hurdler',
                    'Jumper',
                    'Thrower',
                    'Decathlete/Heptathlete'
                ],
                'badminton' => [
                    'Singles Player',
                    'Doubles Player'
                ],
                'table tennis' => [
                    'Singles Player',
                    'Doubles Player'
                ],
                'boxing' => [
                    'Heavyweight',
                    'Middleweight',
                    'Lightweight',
                    'Featherweight',
                    'Flyweight'
                ],
                'wrestling' => [
                    'Freestyle',
                    'Greco-Roman'
                ],
                'gymnastics' => [
//                    'Artistic Gymnastics' => [
                        'All-Around',
                        'Floor Exercise',
                        'Pommel Horse',
                        'Rings',
                        'Vault',
                        'Parallel Bars',
                        'Horizontal Bar',
//                    ],
                    'Rhythmic Gymnastics',
                    'Trampoline'
                ],
                'skiing' => [
//                    'Alpine Skiing' => [
                        'Slalom',
                        'Giant Slalom',
                        'Super-G',
                        'Downhill',
//                    ],
//                    'Nordic Skiing' => [
                        'Cross-Country',
                        'Ski Jumping',
                        'Nordic Combined',
//                    ]
                ],
                'snowboarding' => [
                    'Halfpipe',
                    'Slopestyle',
                    'Giant Slalom',
                    'Parallel Giant Slalom'
                ],
                'surfing' => [
                    'Regular-Footed Surfer',
                    'Goofy-Footed Surfer'
                ],
                'skateboarding' => [
                    'Street Skater',
                    'Vert Skater'
                ],
                'archery' => [
                    'Recurve',
                    'Compound'
                ],
                'shooting' => [
                    'Rifle',
                    'Pistol',
                    'Shotgun'
                ],
                'equestrian' => [
                    'Dressage',
                    'Eventing',
                    'Show Jumping'
                ],
                'weightlifting' => [
                    'Snatch',
                    'Clean and Jerk'
                ],
                'karate' => [
                    'Kata',
                    'Kumite'
                ],
                'judo' => [
                    'Nage-waza (Throwing Techniques)',
                    'Katame-waza (Ground Techniques)'
                ],
                'taekwondo' => [
                    'Poomsae (Forms)',
                    'Kyorugi (Sparring)'
                ],
                'fencing' => [
                    'Foil',
                    'Epee',
                    'Sabre'
                ],
                'canoeing' => [
                    'Sprint',
                    'Slalom'
                ],
                'kayaking' => [
                    'Sprint',
                    'Slalom'
                ],
                'sailing' => [
                    'One-Person Dinghy',
                    'Two-Person Dinghy',
                    'Windsurfing',
                    'Keelboat'
                ],
                'rowing' => [
                    'Single Scull',
                    'Double Scull',
                    'Coxless Pair',
                    'Coxed Pair',
                    'Coxless Four',
                    'Coxed Four',
                    'Eight'
                ],
                'triathlon' => [
                    'Swimming',
                    'Cycling',
                    'Running'
                ],
                'pentathlon' => [
                    'Fencing',
                    'Swimming',
                    'Equestrian',
                    'Cross Country Running',
                    'Pistol Shooting'
                ],
                'bobsleigh' => [
                    'Driver',
                    'Brakeman'
                ],
                'luge' => [
                    'Singles',
                    'Doubles'
                ],
                'skeleton' => [
                    'Singles'
                ],
                'curling' => [
                    'Lead',
                    'Second',
                    'Third (Vice-Skip)',
                    'Skip'
                ],
                'figure skating' => [
                    'Singles',
                    'Pairs',
                    'Ice Dance'
                ],
                'ice hockey' => [
                    'Forward',
                    'Defenseman',
                    'Goaltender'
                ],
                'freestyle skiing' => [
                    'Moguls',
                    'Aerials',
                    'Ski Cross',
                    'Halfpipe',
                    'Slopestyle'
                ],
                'biathlon' => [
                    'Individual',
                    'Sprint',
                    'Pursuit',
                    'Mass Start',
                    'Relay'
                ],
                'water polo' => [
                    'Goalkeeper',
                    'Field Player'
                ],
                'polo' => [
                    'Number 1',
                    'Number 2',
                    'Number 3',
                    'Number 4'
                ],
                'snooker' => [
                    'Potter',
                    'Break Builder'
                ],
                'billiards' => [
                    'Potter',
                    'Break Builder'
                ]
            ];

//            foreach ($sports as $sport) {
//                DB::table('sports')->insert([
//                    'name' => $sport,
//                    'created_at' => now(),
//                    'updated_at' => now(),
//                ]);
//            }
//            Sport::factory()
//                ->count(15)
//                ->create();
            foreach ($sportsWithPositions as $sportName => $positions) {
                $sport = Sport::create(['name' => Str::lower($sportName)]);
                $sport->positions()->createMany(array_map(function ($position) {
                    return ['name' => $position];
                }, $positions));
            }
        }
    }
}
