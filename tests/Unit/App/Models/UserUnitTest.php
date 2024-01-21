<?php

namespace Tests\Unit\App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use PHPUnit\Framework\TestCase;

class UserUnitTest extends TestCase
{
    protected function model(): Model
    {
        return new User();
    }

    public function testIfUseTraits()
    {
        $traitsNeed = [
            HasApiTokens::class,
            HasFactory::class,
            Notifiable::class,
            SoftDeletes::class
        ];

        $traitsUsed = array_keys(class_uses($this->model()));

        $this->assertEquals($traitsNeed, $traitsUsed);
    }

    public function testFillable()
    {
        $expectedFillable = [
            'name',
            'email',
            'password',
        ];

        $fillable = $this->model()->getFillable();

        $this->assertEquals($expectedFillable, $fillable);
    }

    public function testIncrementingIsTrue()
    {
        $model = $this->model();

        $this->assertTrue($model->incrementing);
    }

    public function testHasCasts()
    {
        $expectedCasts = [
            'id' => 'int',
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'deleted_at' => 'datetime',
        ];

        $casts = $this->model()->getCasts();

        $this->assertEquals($expectedCasts, $casts);
    }
}
