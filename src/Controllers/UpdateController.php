<?php

namespace ghulammustafashad\trueinstaller\Controllers;

use Illuminate\Routing\Controller;
use ghulammustafashad\trueinstaller\Helpers\DatabaseManager;
use ghulammustafashad\trueinstaller\Helpers\InstalledFileManager;

class UpdateController extends Controller
{
    use \ghulammustafashad\trueinstaller\Helpers\MigrationsHelper;

    /**
     * Display the updater welcome page.
     *
     * @return \Illuminate\View\View
     */
    public function welcome()
    {
        return view('trueinstaller.update.welcome');
    }

    /**
     * Display the updater overview page.
     *
     * @return \Illuminate\View\View
     */
    public function overview()
    {
        $migrations = $this->getMigrations();
        $dbMigrations = $this->getExecutedMigrations();

        return view('trueinstaller.update.overview', ['numberOfUpdatesPending' => count($migrations) - count($dbMigrations)]);
    }

    /**
     * Migrate and seed the database.
     *
     * @return \Illuminate\View\View
     */
    public function database()
    {
        $databaseManager = new DatabaseManager;
        $response = $databaseManager->migrateAndSeed();

        return redirect()->route('LaravelUpdater::final')
                         ->with(['message' => $response]);
    }

    /**
     * Update installed file and display finished view.
     *
     * @param InstalledFileManager $fileManager
     * @return \Illuminate\View\View
     */
    public function finish(InstalledFileManager $fileManager)
    {
        $fileManager->update();

        return view('trueinstaller.update.finished');
    }
}
