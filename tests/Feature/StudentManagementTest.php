<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudentManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_admin_can_create_search_update_and_delete_students(): void
    {
        $this->actingAs(User::factory()->create());
        $course = Course::create(['course_name' => 'BS Computer Science']);

        $response = $this->post(route('students.store'), [
            'first_name' => 'Morgan',
            'last_name' => 'Reyes',
            'email' => 'morgan@example.com',
            'year_level' => 2,
            'course_id' => $course->course_id,
        ]);

        $student = Student::where('email', 'morgan@example.com')->firstOrFail();
        $response->assertRedirect(route('dashboard'));
        $this->assertDatabaseHas('students', ['student_id' => $student->student_id]);

        $this->get(route('dashboard', ['search' => 'Computer Science']))
            ->assertOk()
            ->assertSee('Morgan')
            ->assertSee('BS Computer Science');

        $this->put(route('students.update', $student->student_id), [
            'first_name' => 'Morgan Lee',
            'last_name' => 'Reyes',
            'email' => 'morgan.lee@example.com',
            'year_level' => 3,
            'course_id' => $course->course_id,
        ])->assertRedirect(route('dashboard'));

        $this->assertDatabaseHas('students', [
            'student_id' => $student->student_id,
            'first_name' => 'Morgan Lee',
            'year_level' => 3,
        ]);

        $this->delete(route('students.destroy', $student->student_id))
            ->assertRedirect(route('dashboard'));

        $this->assertDatabaseMissing('students', ['student_id' => $student->student_id]);
    }

    public function test_student_management_routes_require_authentication(): void
    {
        $this->get(route('dashboard'))->assertRedirect(route('login'));
        $this->get(route('students.create'))->assertRedirect(route('login'));
    }

    public function test_database_seeder_imports_the_provided_sis_records(): void
    {
        $this->seed();

        $this->assertDatabaseHas('courses', [
            'course_id' => 1,
            'course_name' => 'BS Information  Technology',
        ]);
        $this->assertDatabaseHas('students', [
            'student_id' => 21,
            'email' => 'justinekarlagustin@gmail.com',
        ]);
        $this->assertDatabaseHas('users', [
            'user_id' => 2,
            'username' => 'Justine',
        ]);
    }
}
