<?php
// UserAssetHandler.php - Place this in your controllers directory
require_once 'QrCodeController.php';

class UserAssetHandler
{
    private $profilePictureDir;
    private $qrCodeController;

    public function __construct()
    {
        $this->profilePictureDir = __DIR__ . '/../assets/ProfilePictures/';
        $this->qrCodeController = new QrCodeController();
    }

    /**
     * Update user assets when ID number changes
     * 
     * @param string $oldIdNumber The previous ID number
     * @param string $newIdNumber The new ID number
     * @return array Result of the operation
     */
    public function updateUserAssets($oldIdNumber, $newIdNumber)
    {
        $result = [
            'profilePicture' => $this->updateProfilePicture($oldIdNumber, $newIdNumber),
            'qrCode' => $this->updateQrCode($oldIdNumber, $newIdNumber)
        ];

        return $result;
    }

    /**
     * Delete all assets associated with a user
     * 
     * @param string $idNumber User's ID number
     * @return array Result of the operation
     */
    public function deleteUserAssets($idNumber)
    {
        $result = [
            'profilePicture' => $this->deleteProfilePicture($idNumber),
            'qrCode' => $this->deleteQrCode($idNumber)
        ];

        return $result;
    }

    /**
     * Update profile picture filename when ID changes
     */
    private function updateProfilePicture($oldIdNumber, $newIdNumber)
    {
        $extensions = ['jpg', 'jpeg', 'png', 'gif'];
        $oldFile = null;
        $newFile = null;

        // Find the existing profile picture with its extension
        foreach ($extensions as $ext) {
            $potentialFile = $this->profilePictureDir . $oldIdNumber . '.' . $ext;
            if (file_exists($potentialFile)) {
                $oldFile = $potentialFile;
                $newFile = $this->profilePictureDir . $newIdNumber . '.' . $ext;
                break;
            }
        }

        // If no profile picture exists, nothing to update
        if (!$oldFile) {
            return ['success' => true, 'message' => 'No profile picture found to update'];
        }

        // Rename the file
        try {
            if (rename($oldFile, $newFile)) {
                return ['success' => true, 'message' => 'Profile picture updated successfully'];
            } else {
                return ['success' => false, 'message' => 'Failed to rename profile picture'];
            }
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Error updating profile picture: ' . $e->getMessage()];
        }
    }

    /**
     * Delete and regenerate QR code when ID changes
     */
    private function updateQrCode($oldIdNumber, $newIdNumber)
    {
        // First delete the old QR code
        $this->deleteQrCode($oldIdNumber);

        // Generate a new QR code with the new ID
        return $this->qrCodeController->generateQrCode($newIdNumber);
    }

    /**
     * Delete a user's profile picture
     */
    private function deleteProfilePicture($idNumber)
    {
        $extensions = ['jpg', 'jpeg', 'png', 'gif'];
        $fileDeleted = false;

        foreach ($extensions as $ext) {
            $filename = $this->profilePictureDir . $idNumber . '.' . $ext;
            if (file_exists($filename)) {
                if (unlink($filename)) {
                    $fileDeleted = true;
                }
            }
        }

        return [
            'success' => true,
            'message' => $fileDeleted ? 'Profile picture deleted successfully' : 'No profile picture found to delete'
        ];
    }

    /**
     * Delete a user's QR code
     */
    private function deleteQrCode($idNumber)
    {
        $filename = $this->qrCodeController->sanitizeFilename($idNumber) . '.png';
        $filepath = $this->qrCodeController->getBaseDir() . $filename;

        if (file_exists($filepath)) {
            if (unlink($filepath)) {
                return ['success' => true, 'message' => 'QR code deleted successfully'];
            } else {
                return ['success' => false, 'message' => 'Failed to delete QR code'];
            }
        }

        return ['success' => true, 'message' => 'No QR code found to delete'];
    }
}
