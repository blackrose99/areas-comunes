<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Area;

class AreaFactory extends Factory
{
    protected $model = Area::class;

    public function definition()
    {
        return [
            'name' => $this->faker->randomElement(['Piscina', 'Gimnasio', 'Jardines', 'Sala de juegos', 'Cancha de fútbol', 'Cancha de tenis', 'BBQ', 'Sala de reuniones', 'Parque infantil', 'Biblioteca']),
            'description' => $this->faker->sentence(),
            'type' => $this->faker->randomElement(['deportiva', 'recreativa', 'social']),
            'status' => $this->faker->randomElement(['active', 'inactive']),
            'capacity' => $this->faker->numberBetween(10, 100),
            'opening_date' => now(),
            'closing_date' => now()->addYears(5),
            'opening_time' => $this->faker->time('H:i', '06:00'), // Desde las 6 AM
            'closing_time' => $this->faker->time('H:i', '22:00'), // Hasta las 10 PM
        ];
    }
}
