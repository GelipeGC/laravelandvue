<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Category;
use App\Note;
class ApiNoteTest extends TestCase
{
    use DatabaseTransactions;
    protected $note = 'Is this a note';
    public function test_list_notes()
    {
    	$category = factory(Category::class)->create();
    	$notes = factory(Note::class)->times(2)->create([
    			'category_id' => $category->id
    		]);
        $this->get('api/v1/notes')
        	->assertResponseOk() //200
        	->seeJsonEquals($notes->toArray());
    }

    public function test_can_create_a_note()
    {
        $category = factory(Category::class)->create();

        $this->post('api/v1/notes', [
            'note'      => $this->note, 
            'category_id'  => $category->id,

            ]);
        $this->seeInDatabase('notes', [
                'note' => $this->note,
                'category_id' => $category->id,
            ]);

        $this->seeJsonEquals([
            'success' => true,
            'note' => Note::first()->toArray(),
            ]);
    }



    function test_validation_when_creating_a_note()
    {
        //$category = factory(Category::class)->create();

        $this->post('api/v1/notes', [
            'note'      => '', 
            'category_id'  => 100,

            ], ['Accept' => 'application/json']);
        $this->dontSeeInDatabase('notes', [
                'note' => '',
                
            ]);
        $this->seeJsonEquals([
            'success' => false,
            'errors'    => 'The note field is required.',
            'The selected category id is invalid.',
            ]);
    }

    public function test_can_update_a_note()
    {
        $text = 'Updated note';

        $category = factory(Category::class)->create();

        $anotherCategory = factory(Category::class)->create();

        $note = Factory(Note::class)->make();

        $category->notes()->save($note);

        $this->put('api/v1/notes/'.$note->id, [
            'note'      => $text, 
            'category_id'  => $anotherCategory->id,

            ]);
        $this->seeInDatabase('notes', [
                'note' => $text,
                'category_id' => $anotherCategory->id,
            ]);

        $this->seeJsonEquals([
            'success' => true,
            'note' => [
                'id' => $note->id,
                'note' => $text,
                'category_id' => $anotherCategory->id,
            ],

        ]);
    }

   

    function test_validation_when_updating_a_note()
    {
        $category = factory(Category::class)->create();

        $note = Factory(Note::class)->make();

        $category->notes()->save($note);

        $this->put('api/v1/notes/'.$note->id, [
            'note'      => '', 
            'category_id'  => 100,

            ],['Accept' => 'application/json']);
        
        $this->dontSeeInDatabase('notes', [
            'id'    =>$note->id,
            'note' => '',
                
            ]);
        $this->seeJsonEquals([
            'success' => false,
            'errors'    => ['The note field is required.',
            'The selected category id is invalid.',
            ]

            ]);
    }

    function test_can_delete_a_note()
    {
        $note = factory(Note::class)->create();
        $this->delete('api/v1/notes/'.$note->id, [],['Accept' => 'application/json']);
        $this->dontSeeInDatabase('notes', [
                'id' => $note->id
            ]);
        $this->seeJsonEquals([
                'success' =>true
            ]);
    }
}
