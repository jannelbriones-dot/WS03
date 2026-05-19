<?php

namespace App\Controllers;

use framework\Database;
use framework\Validation;
use framework\Session;

class ListingController
{
    protected Database $db;

    public function __construct()
    {
        $config = require basePath('config/db.php');
        $this->db = new Database($config);
    }

    public function index()
    {
        $listings = $this->db
            ->query('SELECT * FROM listings ORDER BY created_at DESC')
            ->fetchAll();

        loadView('listings/index', [
            'listings' => $listings
        ]);
    }

    public function create()
    {
        loadView('listings/create');
    }

    public function show(array $params)
    {
        $id = $params['id'] ?? null;

        if (!$id) {
            die('Listing ID not found');
        }

        $listing = $this->db
            ->query('SELECT * FROM listings WHERE id = :id', ['id' => $id])
            ->fetch();

        if (!$listing) {
            ErrorController::notFound('Listing not found');
            return;
        }

        loadView('listings/show', [
            'listing' => $listing
        ]);
    }

    public function store()
    {
        $allowedFields = [
            'title',
            'description',
            'salary',
            'tags',
            'company',
            'address',
            'city',
            'state',
            'phone',
            'email',
            'requirements',
            'benefits'
        ];

        $newListingData = array_intersect_key(
            $_POST,
            array_flip($allowedFields)
        );

        $newListingData['user_id'] = Session::get('user') ['id'];

        $newListingData = array_map('sanitize', $newListingData);

        $requiredFields = ['title', 'description', 'salary', 'email', 'city', 'state'];

        $errors = [];

        foreach ($requiredFields as $field) {
            if (
                empty($newListingData[$field]) ||
                !Validation::string($newListingData[$field])
            ) {
                $errors[$field] = ucfirst($field) . ' is required';
            }
        }

        if (!empty($errors)) {
            loadView('listings/create', [
                'errors' => $errors,
                'old' => $newListingData
            ]);
            return;
        }

        $fields = implode(', ', array_keys($newListingData));
        $placeholders = ':' . implode(', :', array_keys($newListingData));

        $query = "INSERT INTO listings ({$fields}) VALUES ({$placeholders})";

        $this->db->query($query, $newListingData);

        // Set success message in session
        $_SESSION['message'] = 'Listing created successfully!';
        $_SESSION['message_type'] = 'success';

        redirect('/listings');
    }

    public function edit(array $params)
    {
        $id = $params['id'] ?? null;

        if (!$id) {
            die('Listing ID not found');
        }

        $listing = $this->db
            ->query('SELECT * FROM listings WHERE id = :id', ['id' => $id])
            ->fetch();

        if (!$listing) {
            ErrorController::notFound('Listing not found');
            return;
        }

        if(Session::get('user')['id'] !== $listing->user_id) {
            $_SESSION['error_message'] = 'You are not authorized to delete this listing';
            return redirect('/listings/' . $listing->id);        
            }

        loadView('listings/edit', [
            'listing' => $listing
        ]);
    }

    /**
     * Update listing
     * 
     * @param array $params
     * @return void
     */
    public function update(array $params)
    {
        $id = $params['id'] ?? null;

        if (!$id) {
            die('Listing ID not found');
        }

        // Check if listing exists
        $listing = $this->db
            ->query('SELECT * FROM listings WHERE id = :id', ['id' => $id])
            ->fetch();

        if (!$listing) {
            ErrorController::notFound('Listing not found');
            return;
        }

        $allowedFields = [
            'title',
            'description',
            'salary',
            'tags',
            'company',
            'address',
            'city',
            'state',
            'phone',
            'email',
            'requirements',
            'benefits'
        ];

        $updatedValues = array_intersect_key($_POST, array_flip($allowedFields));
        $updatedValues = array_map('sanitize', $updatedValues);

        $requiredFields = ['title', 'description', 'salary', 'email', 'city', 'state'];
        $errors = [];

        foreach ($requiredFields as $field) {
            if (
                empty($updatedValues[$field]) ||
                !Validation::string($updatedValues[$field])
            ) {
                $errors[$field] = ucfirst($field) . ' is required';
            }
        }

        if (!empty($errors)) {
            loadView('listings/edit', [
                'errors' => $errors,
                'listing' => $listing
            ]);
            exit;
        }
        
        $updateFields = [];
        
        foreach (array_keys($updatedValues) as $field) {
            $updateFields[] = "$field = :$field";
        }
        
        $updateFields = implode(', ', $updateFields);
        $updateQuery = "UPDATE listings SET {$updateFields} WHERE id = :id";
        
        // Add the id to the updated values
        $updatedValues['id'] = $id;
        
        // Execute the query
        $this->db->query($updateQuery, $updatedValues);
        
        // Set success message
        $_SESSION['success_message'] = 'Listing updated successfully!';
     
        
        redirect('/listings');
    }
}