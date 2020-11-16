<?php


namespace App\Contracts;


interface PostContract
{
    /**
     * Retrieve all posts
     *
     * @return object posts
     */
    public function fetchAll();

    /**
     * retrieve specific post
     *
     * @param $id integer post id
     * @return object post
     */
    public function fetch($id);

    /**
     * Retrieve 8 post's Views
     * @param $id integer post id
     */
    public function getPostView($id);

    /**
     * Retrieve all Views
     */
    public function getViews();
}
