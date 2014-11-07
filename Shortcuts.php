<?php

namespace Knife;

use Backend\Core\Engine\Language as BL;
use Backend\Core\Engine\Model as BackendModel;
use Frontend\Core\Engine\Model as FrontendModel;


/**
 * Collection of often used code patterns in Fork.
 *
 * @author <per@wijs.be>
 */
class Shortcuts
{
    /** @type bool */
    const INCLUDE_SOURCE_FOLDER = true;

    /**
     * Make a slug unique for a given item in a db table.
     *
     * Set it as "url callback" of a BackendMetaObject:
     *
     *        $this->meta->setUrlCallback(
     *            'Utils\Fork\Shortcuts', // TODO this or just 'Shortcuts'?
     *            'makeUniqueSlug',
     *            array('blog_posts', $this->record['id'])
     *        );
     *
     * Alternatively, call this method from BackendMyModuleModel::getURL() and
     * the likes.
     *
     * @param string $slug The proposed slug.
     * @param string $table The db table name where the items are stored that need
     *        a slug.
     * @param int[optional] Optional ID in the database of an item.
     *        When this is set, we're dealing with an edit of an existing item.
     */
    public static function makeUniqueSlug($slug, $table, $id = null)
    {
        $sql = "SELECT 1 FROM $table i
            INNER JOIN meta m ON i.meta_id = m.id
            WHERE i.language = :language AND m.url = :slug";
        $params = array(
            'language' => BL::getWorkingLanguage(),
            'slug' => $slug,
        );
        if ($id) {
            $sql .= ' AND i.id <> :id';
            $params['id'] = $id;
        }
        $sql .= ' LIMIT 1';
        return ((bool) BackendModel::getContainer()->get('database')->getVar($sql, $params))
            ? self::makeUniqueSlug(BackendModel::addNumber($slug), $table, $id)
            : $slug;
    }

    /**
     * @param mixed $ids Hopefully a list of ids
     * @return int[] A list of integers, supposedly ID's in a database.
     */
    public static function ensureIdList($ids)
    {
        $ids = (array) $ids;
        foreach ($ids as &$id) {
            $id = (int) $id;
        }
        return $ids;
    }

    /**
     * Group a bunch of records, ex, given $records as:
     * name | age | gender
     * foo  | 4   | m
     * bar  | 6   | m
     * fu   | 6   | f
     * baz  | 3   | f
     *
     * groupRecords($records, 'gender') will return the same data, but grouped
     * by the value for gender, so in this case:
     *
     * array(
     *  'm' => array(
     *      array('name' => 'foo', 'age' => 4, 'gender' => 'm'),
     *      array('name' => 'bar', 'age' => 6, 'gender' => 'm'),
     *  ),
     *  'f' => array(
     *      array('name' => 'fu', 'age' => 6, 'gender' => 'f'),
     *      array('name' => 'baz', 'age' => 3, 'gender' => 'f'),
     *  )
     * )
     *
     * @param array $records The record set to group
     * @param string $col The name of the column to group on its values.
     * @return array Grouped record set.
     */
    public static function groupRecords(array $records, $col)
    {
        $grouped = array();
        foreach ($records as $record) {
            $key = $record[$col];
            if (!isset($grouped[$key])) {
                $grouped[$key] = array();
            }
            $grouped[$key][] = $record;
        }
        return $grouped;
    }

    /**
     * @param int[] $ids List of ID's in a database
     * @return string SQL placeholder to use in an 'IN ()' query
     * @throws \Exception when passed an empty list, since 'IN ()' is invalid.
     */
    public static function makeSqlIdPlaceHolders($ids)
    {
        if (empty($ids)) {
            throw new \Exception("Cannot create valid SQL part if list is empty.");
        }
        return implode(', ', array_fill(0, count($ids), '?'));
    }

    /**
     * @param SpoonTemplate $tpl Template to replace the page title.
     * @param string $newTitle The new page title for the template.
     */
    public static function replacePageTitle($tpl, $newTitle)
    {
        $tpl->assign('hideContentTitle', false);
        $tplVars = $tpl->getAssignedVariables();
        $tplVars['page']['title'] = $newTitle;
        $tpl->assign($tplVars);
    }

    /**
     * @param string $frontendFilesSubDir The sub directory under FRONTEND_FILES_PATH
     *        should start with a '/', no warranties on how this method behaves
     *        if not.
     * @param string $filename The base file name of the image.
     * @return array structure for the images so that they can be used as-is in
     *         a template.
     * @internal This method does no checking on the existence of the directory
     *           and or file name whatsoever.
     */
    public static function getFrontendImages($frontendFilesSubDir, $filename)
    {
        $folders = FrontendModel::getThumbnailFolders(
            FRONTEND_FILES_PATH . $frontendFilesSubDir,
            self::INCLUDE_SOURCE_FOLDER
        );
        $images = array();
        foreach ($folders as $folder) {
            $folder['path'] .= "/$filename";
            $folder['url'] .= sprintf("/{$folder['dirname']}/$filename?%s", time());
            $images[$folder['dirname']] = $folder;
        }
        return $images;
    }
}
