<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class EventManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_event_list_contains_only_the_authenticated_users_events(): void
    {
        $user = User::factory()->create();
        $event = $user->events()->create([
            'title' => 'Lecture',
            'start_date' => '2026-11-01',
        ]);
        User::factory()->create()->events()->create([
            'title' => 'Private event',
            'start_date' => '2026-11-02',
        ]);

        $this->actingAs($user)->get(route('events.index'))
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Events/Index', false)
                ->has('events', 1)
                ->where('events.0.id', $event->id)
                ->where('events.0.title', 'Lecture'));
    }

    public function test_user_can_create_an_event_with_optional_fields(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->post(route('events.store'), [
            'title' => 'Midterm',
            'description' => 'Chapters 1-4',
            'start_date' => '2026-11-01',
            'start_time' => '09:30',
            'end_date' => '2026-11-01',
            'end_time' => '11:00',
            'location' => 'Room 12',
            'event_type' => 'exam',
        ])->assertSessionHasNoErrors()->assertRedirect(route('events.index'));

        $this->assertDatabaseHas('events', [
            'user_id' => $user->id,
            'title' => 'Midterm',
            'start_date' => '2026-11-01',
            'start_time' => '09:30',
            'end_date' => '2026-11-01',
            'location' => 'Room 12',
            'event_type' => 'exam',
        ]);
    }

    public function test_event_requires_a_start_date_and_end_date_cannot_precede_it(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->from(route('events.create'))->post(route('events.store'), [
            'title' => 'Invalid event',
            'start_date' => '2026-11-05',
            'end_date' => '2026-11-04',
        ])->assertSessionHasErrors(['end_date']);

        $this->actingAs($user)->from(route('events.create'))->post(route('events.store'), [
            'title' => 'Missing date',
        ])->assertSessionHasErrors(['start_date']);

        $this->assertDatabaseCount('events', 0);
    }

    public function test_user_can_update_and_delete_their_event(): void
    {
        $user = User::factory()->create();
        $event = $this->createEvent($user);

        $this->actingAs($user)->put(route('events.update', $event), [
            'title' => 'Updated lecture',
            'start_date' => '2026-11-03',
            'start_time' => '10:00',
            'end_date' => '2026-11-03',
            'end_time' => '11:00',
            'location' => 'Room 20',
            'event_type' => 'seminar',
        ])->assertSessionHasNoErrors()->assertRedirect(route('events.index'));

        $this->assertDatabaseHas('events', [
            'id' => $event->id,
            'title' => 'Updated lecture',
            'start_date' => '2026-11-03',
            'location' => 'Room 20',
        ]);

        $this->actingAs($user)->delete(route('events.destroy', $event))
            ->assertRedirect(route('events.index'));

        $this->assertDatabaseMissing('events', ['id' => $event->id]);
    }

    public function test_event_creation_rejects_another_users_subject(): void
    {
        $user = User::factory()->create();
        $otherUsersSubject = User::factory()->create()->subjects()->create(['name' => 'Private']);

        $this->actingAs($user)->from(route('events.create'))->post(route('events.store'), [
            'subject_id' => $otherUsersSubject->id,
            'title' => 'Lecture',
            'start_date' => '2026-11-01',
        ])->assertSessionHasErrors(['subject_id']);

        $this->assertDatabaseCount('events', 0);
    }

    #[DataProvider('eventActions')]
    public function test_other_users_cannot_view_or_change_an_event(string $method, string $route): void
    {
        $event = $this->createEvent(User::factory()->create());

        $this->actingAs(User::factory()->create())->{$method}(route($route, $event), [
            'title' => 'Unauthorized update',
            'start_date' => '2026-11-02',
        ])->assertForbidden();

        $this->assertDatabaseHas('events', ['id' => $event->id, 'title' => 'Original event']);
    }

    #[DataProvider('eventActions')]
    public function test_guests_are_redirected_to_login_for_event_actions(string $method, string $route): void
    {
        $event = $this->createEvent(User::factory()->create());

        $this->{$method}(route($route, $event))->assertRedirect(route('login'));
    }

    public function test_edit_form_formats_event_dates_and_times_for_inputs(): void
    {
        $user = User::factory()->create();
        $event = $user->events()->create([
            'title' => 'Lecture',
            'start_date' => '2026-11-01',
            'start_time' => '09:30',
            'end_date' => '2026-11-01',
            'end_time' => '11:00',
        ]);

        $this->actingAs($user)->get(route('events.edit', $event))
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Events/Edit', false)
                ->where('event.id', $event->id)
                ->where('event.start_date', '2026-11-01')
                ->where('event.start_time', '09:30')
                ->where('event.end_date', '2026-11-01')
                ->where('event.end_time', '11:00'));
    }

    public static function eventActions(): array
    {
        return [
            'view' => ['get', 'events.show'],
            'edit' => ['get', 'events.edit'],
            'update' => ['put', 'events.update'],
            'delete' => ['delete', 'events.destroy'],
        ];
    }

    private function createEvent(User $user): Event
    {
        return $user->events()->create([
            'title' => 'Original event',
            'start_date' => '2026-11-01',
        ]);
    }
}
