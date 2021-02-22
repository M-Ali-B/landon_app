<?php

namespace Tests\Unit;

use App\Title;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $this->assertTrue(true);
    }
    public function testTitleArrayCount() {
        $titles = new Title();
        $this->assertTrue(  count($titles->all() )== 6, 'Title array contains 6 titles');
    }

    public function checkTitleProfessor() {
        $title = new Title();
        $title_array = $title->all();
        $this->assertEquals('Professor',array_pop($title_array), 'Should be equal to Professor ');
    }
}
