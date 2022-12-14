<?php

namespace Tests\Feature\Filters;

use App\Http\Livewire\IdeasIndex;
use App\Models\Category;
use App\Models\Idea;
use App\Models\Status;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class CategoryFiltersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function selecting_a_category_filters_correctly()
    {
        $categoryOne = Category::factory()->create(['name' => 'Gold']);
        $categoryTwo = Category::factory()->create(['name' => 'Silver']);

        $ideaOne = Idea::factory()->create([
            'category_id' => $categoryOne->id,
        ]);

        $ideaTwo = Idea::factory()->create([
            'category_id' => $categoryOne->id,
        ]);

        $ideaThree = Idea::factory()->create([
            'category_id' => $categoryTwo->id,
        ]);

        Livewire::test(IdeasIndex::class)
            ->set('category', 'Gold')
            ->assertViewHas('ideas', function ($ideas) {
                return $ideas->count() === 2
                    && $ideas->first()->category->name === 'Gold';
            });
    }

    /** @test */
    public function the_category_query_string_filters_correctly()
    {
        $categoryOne = Category::factory()->create(['name' => 'Gold']);
        $categoryTwo = Category::factory()->create(['name' => 'Silver']);

        $ideaOne = Idea::factory()->create([
            'category_id' => $categoryOne->id,
        ]);

        $ideaTwo = Idea::factory()->create([
            'category_id' => $categoryOne->id,
        ]);

        $ideaThree = Idea::factory()->create([
            'category_id' => $categoryTwo->id,
        ]);

        Livewire::withQueryParams(['category' => 'Gold'])
            ->test(IdeasIndex::class)
            ->assertViewHas('ideas', function ($ideas) {
                return $ideas->count() === 2
                    && $ideas->first()->category->name === 'Gold';
            });
    }

    /** @test */
    public function selecting_a_status_and_a_category_filters_correctly()
    {
        $categoryOne = Category::factory()->create(['name' => 'Gold']);
        $categoryTwo = Category::factory()->create(['name' => 'Silver']);

        $statusOpen = Status::factory()->create(['name' => 'Open']);
        $statusConsidering = Status::factory()->create(['name' => 'Considering']);

        $ideaOne = Idea::factory()->create([
            'category_id' => $categoryOne->id,
            'status_id' => $statusOpen->id,
        ]);

        $ideaTwo = Idea::factory()->create([
            'category_id' => $categoryOne->id,
            'status_id' => $statusConsidering->id,
        ]);

        $ideaThree = Idea::factory()->create([
            'category_id' => $categoryTwo->id,
            'status_id' => $statusOpen->id,
        ]);

        $ideaFour = Idea::factory()->create([
            'category_id' => $categoryTwo->id,
            'status_id' => $statusConsidering->id,
        ]);

        Livewire::test(IdeasIndex::class)
            ->set('status', 'Open')
            ->set('category', 'Gold')
            ->assertViewHas('ideas', function ($ideas) {
                return $ideas->count() === 1
                    && $ideas->first()->category->name === 'Gold'
                    && $ideas->first()->status->name === 'Open';
            });
    }

    /** @test */
    public function the_category_query_string_filters_correctly_with_status_and_category()
    {
        $categoryOne = Category::factory()->create(['name' => 'Gold']);
        $categoryTwo = Category::factory()->create(['name' => 'Silver']);

        $statusOpen = Status::factory()->create(['name' => 'Open']);
        $statusConsidering = Status::factory()->create(['name' => 'Considering']);

        $ideaOne = Idea::factory()->create([
            'category_id' => $categoryOne->id,
            'status_id' => $statusOpen->id,
        ]);

        $ideaTwo = Idea::factory()->create([
            'category_id' => $categoryOne->id,
            'status_id' => $statusConsidering->id,
        ]);

        $ideaThree = Idea::factory()->create([
            'category_id' => $categoryTwo->id,
            'status_id' => $statusOpen->id,
        ]);

        $ideaFour = Idea::factory()->create([
            'category_id' => $categoryTwo->id,
            'status_id' => $statusConsidering->id,
        ]);

        Livewire::withQueryParams(['status' => 'Open', 'category' => 'Gold'])
            ->test(IdeasIndex::class)
            ->assertViewHas('ideas', function ($ideas) {
                return $ideas->count() === 1
                    && $ideas->first()->category->name === 'Gold'
                    && $ideas->first()->status->name === 'Open';
            });
    }

    /** @test */
    public function selecting_all_categories_filters_correctly()
    {
        $categoryOne = Category::factory()->create(['name' => 'Gold']);
        $categoryTwo = Category::factory()->create(['name' => 'Silver']);

        $ideaOne = Idea::factory()->create([
            'category_id' => $categoryOne->id,
        ]);

        $ideaTwo = Idea::factory()->create([
            'category_id' => $categoryOne->id,
        ]);

        $ideaThree = Idea::factory()->create([
            'category_id' => $categoryTwo->id,
        ]);

        Livewire::test(IdeasIndex::class)
            ->set('category', 'All Categories')
            ->assertViewHas('ideas', function ($ideas) {
                return $ideas->count() === 3;
            });
    }
}
