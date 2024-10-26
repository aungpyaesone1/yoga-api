<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Course;
use App\Models\ClassModel;
use App\Models\Book;

class YogaController extends Controller
{
    public function store(Request $data) {
        $course = Course::create([
            'day' => $data['day'],
            'time' => $data['time'],
            'capacity' => $data['capacity'],
            'duration' => $data['duration'],
            'price' => $data['price'],
            'type' => $data['type'],
            'level' => $data['level'],
            'description' => $data['description'],
        ]);

        foreach ($data['yogaClasses'] as $classData) {
            ClassModel::create([
                'date_class' => $classData['date'],
                'teacher' => $classData['teacher'],
                'comment' => $classData['comment'],
                'day' => $classData['day'],
                'course_id' => $course->id
            ]);
        }

        return response()->json(['message' => 'Course and classes saved successfully']);
    }

    public function getData() {
        $courses = DB::table('courses')
        ->select('*')
        ->get();
        foreach ($courses as $course) {
            $classes = DB::table('class_models')
                ->select('*')
                ->where('course_id', $course->id)
                ->get();
    
            $course->classes = $classes;
        }

        return response()->json($courses);
    }

    public function book(Request $request) {
        $class_id = $request->classId;
        $email = $request->email;
        Book::create([
            'class_id' => $class_id,
            'email' => $email,
            'name' => $request->name
        ]);
        return response()->json(['message' => 'You have been booked successfully']);
    }

    public function getBooking() {
        $bookings = DB::table('books')
                    ->join('class_models', 'books.class_id', '=', 'class_models.id')
                    ->join('courses', 'class_models.course_id', '=', 'courses.id')
                    ->select('books.email','books.name','class_models.teacher', 'class_models.date_class as date', 'courses.duration', 'courses.price', 'courses.type', 'courses.level')
                    ->get();
        return response()->json($bookings);
    }
}
