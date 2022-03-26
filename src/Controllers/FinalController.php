<?php

namespace GhulamMustafaShad\TrueInstaller\Controllers;

use Illuminate\Routing\Controller;
use GhulamMustafaShad\TrueInstaller\Events\LaravelInstallerFinished;
use GhulamMustafaShad\TrueInstaller\Helpers\EnvironmentManager;
use GhulamMustafaShad\TrueInstaller\Helpers\FinalInstallManager;
use GhulamMustafaShad\TrueInstaller\Helpers\InstalledFileManager;

class FinalController extends Controller
{
    /**
     * Update installed file and display finished view.
     *
     * @param \GhulamMustafaShad\TrueInstaller\Helpers\InstalledFileManager $fileManager
     * @param \GhulamMustafaShad\TrueInstaller\Helpers\FinalInstallManager $finalInstall
     * @param \GhulamMustafaShad\TrueInstaller\Helpers\EnvironmentManager $environment
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function finish(InstalledFileManager $fileManager, FinalInstallManager $finalInstall, EnvironmentManager $environment)
    {
        $finalMessages = $finalInstall->runFinal();
        $finalStatusMessage = $fileManager->update();
        $finalEnvFile = $environment->getEnvContent();

        event(new LaravelInstallerFinished);

        return view('trueinstaller.finished', compact('finalMessages', 'finalStatusMessage', 'finalEnvFile'));
    }
}
