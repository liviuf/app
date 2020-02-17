<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace MiniBlog;

use MiniBlog\Database;

/**
 * Description of Articles
 *
 * @author liviu
 */
class Articles extends AbstractBlog{
    
    /**
     * Get counter of articles
     * 
     * @param int $categoryId
     * @return int
     */
    public function getCount($categoryId = NULL)
    {
        $conn = Database::connect();
        
        if(is_null($categoryId)) {
            $sql = "SELECT count(*) FROM article";
            $count = $conn->query($sql)->fetchColumn();
        } else {
            $sql = "SELECT count(*) FROM article WHERE category_id = ?";
            $smtp = $conn->prepare($sql);
            $smtp->execute([$categoryId]);
            $count = $smtp->fetchColumn();
        }
        
        return $count;
    }
    
    /**
     * Get articles with limit 
     * @param int $offset
     * @param int $limit
     * @return array
     */
    public function getArticlesWithLimit($offset = 0, $limit = 10) {
        
        $conn = Database::connect();
        $results = [];
        
        $sql = "SELECT * FROM article  ORDER BY created_at DESC LIMIT " . $limit . " OFFSET " . $offset;
        
        $results = $conn->query($sql);
        
        return $results->fetchAll(\PDO::FETCH_ASSOC);
        
    }
    
    /**
     * Get all the categories of articles
     * @return array
     */
    public function getAllCategories() {
        $conn = Database::connect();
        $sql = "SELECT * FROM category";
        
        $results = $conn->query($sql);
        
        $categories = $results->fetchAll(\PDO::FETCH_ASSOC);
        
        foreach($categories as $category) {
            $mappedCategories[$category['category_id']] = $category['title'];
        }
        return $mappedCategories;
    }
    
    /**
     * Get all articles by category with limit
     * @param int $categoryId
     * @param int $offset
     * @param int $limit
     * @return array
     */
    public function getAllArticlesByCategoryWithLimit($categoryId, $offset = 0, $limit = 10) {
        $conn = Database::connect();
        

        
        $sql = "SELECT * FROM article WHERE category_id = " . $categoryId . " LIMIT " . $limit . " OFFSET " . $offset;
        
        $results = $conn->query($sql);
        return $results->fetchAll();
    }
    
    /**
     * Create a new articles
     * 
     * @param string $title
     * @param string $description
     * @param int $categoryId
     * @param string $imgPath
     * @return int
     * @throws Exception
     */
    public function createArticle($title, $description, $categoryId, $imgPath) {
        
        $conn = Database::connect();
        $createdAt = date('Y-m-d H:i:s');

        $sql = "INSERT INTO article (title, content, category_id, image, created_at) VALUES (:title, :content, :categoryId, :image, :created_at)";
        
        $smtp = $conn->prepare($sql);
        
        $smtp->bindParam(':title', $title ,\PDO::PARAM_STR);
        $smtp->bindParam(':content', $description, \PDO::PARAM_STR);
        $smtp->bindParam(':categoryId', $categoryId, \PDO::PARAM_INT);
        $smtp->bindParam(':image', $imgPath, \PDO::PARAM_STR);
        $smtp->bindParam(':created_at', $createdAt, \PDO::PARAM_STR);
        
        try {
            $result = $smtp->execute();
        } catch (\Exception $ex) {
            throw new $ex;
        }
        
        return $result;
        
    }
    
    /**
     * Update an existing article 
     * 
     * @param int $id
     * @param string $title
     * @param string $description
     * @param int $categoryId
     * @param string $imgPath
     * @throws Exception
     */
    public function updateArticle($id, $title, $description, $categoryId, $imgPath) {
        $conn = Database::connect();
        $updatedAt = date('Y-m-d H:i:s');
        
        $sql = "UPDATE article SET title = :title, content = :content, category_id = :category_id, image = :image, updated_at = :updated_at WHERE article_id = :article_id";
        $smtp = $conn->prepare($sql);
        $smtp->bindParam(':title', $title ,\PDO::PARAM_STR);
        $smtp->bindParam(':content', $description, \PDO::PARAM_STR);
        $smtp->bindParam(':category_id', $categoryId, \PDO::PARAM_INT);
        $smtp->bindParam(':article_id', $id, \PDO::PARAM_INT);
        $smtp->bindParam(':image', $imgPath, \PDO::PARAM_STR);
        $smtp->bindParam(':updated_at', $updatedAt, \PDO::PARAM_STR);
        
        try {
            $smtp->execute();
        } catch (\PDOException $ex) {
            throw new $ex;
        }
        
    }
    
    /**
     * Find an article by his id
     * 
     * @param int $id
     * @return array
     * @throws Exception
     */
    public function findById($id) {
        
        $result = [];
        $conn = Database::connect();
        
        $sql = "SELECT * FROM article WHERE article_id = :id ";
        
        $smtp = $conn->prepare($sql);
        
        
        $smtp->bindParam(':id', $id, \PDO::PARAM_INT);
        
        try {
            $smtp->execute();
        } catch (Exception $ex) {
            throw new $ex;
        }
        
        $result = $smtp->fetch();
        
        return $result;
    }
    
    public function deleteById($id) {
        
        $conn = Database::connect();
        
        $article = $this->findById($id);
        
        echo json_encode($article);
        
        
        if(!empty($article)) {
            $sql = "DELETE FROM article WHERE article_id = :article_id ";
            
            $smtp = $conn->prepare($sql);
            
            $smtp->bindParam(':article_id', $id, \PDO::PARAM_INT);
            
            try {
                $smtp->execute();
            } catch (Exception $ex) {
                throw new $ex;
            }
        }
        
    }
}
