<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        test('meerkeuze, goed antwoord lever punten op', function() {
                $question = Question::factory()->create(['correct_option'=> 1, 'points'=> 10]);
                $student = Student::factory()->create();
                $this->withCookie('player_token', $student->play_token)
                    ->get(route('play.show', $question));

            $this->withCookie('player_token', $student->play_token)
                ->post(route('play.submit', $question, ['selected_option'=> 1]));

            expect($student->fresh()->totalPoints())->toBe(10);
        });
    }
}
